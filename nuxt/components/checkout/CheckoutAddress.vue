<script setup>
import { formatDataToSelect } from '#imports'
import _ from 'lodash'

const emits = defineEmits(['onLocation'])
const { $axios } = useNuxtApp()

const provinces = ref([])
const districts = ref([])
const wards = ref([])
const isLoading = ref(false)
const location = reactive({
  province_id: '',
  district_id: '',
  ward_id: '',
  shipping_address: '',
})

const getGeolocation = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const { latitude, longitude } = position.coords
        getCityAndSetShippingAddress(latitude, longitude)
      },
      (err) => {
        console.log(err)

        return alert('Có lỗi khi lấy vị trí vui lòng thử lại.')
      }
    )
  } else {
    return alert('Geolocation is not supported by this browser.')
  }
}

const getCityAndSetShippingAddress = async (lat, lon) => {
  try {
    isLoading.value = true
    const response = await fetch(
      `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`
    )

    if (!response.ok) {
      throw new Error('Không thể lấy vị trí từ API.')
    }

    const data = await response.json()

    location.shipping_address = data?.display_name
    await getLocationByAddress(data)
  } catch (err) {
    return alert('Có lỗi khi lấy vị trí vui lòng thử lại.')
  } finally {
    isLoading.value = false
  }
}

const handleLocationChange = async (target, location_id) => {
  const response = await $axios.get('location/getLocation', {
    params: { target, location_id },
  })

  const responseFormat = formatDataToSelect(
    response.data[target],
    'code',
    'name'
  )

  emits('onLocation', target)

  if (target === 'districts') {
    districts.value = responseFormat
  } else if (target === 'wards') {
    wards.value = responseFormat
  }
}

const getProvinces = async () => {
  const response = await $axios.get('location/provinces')
  provinces.value = formatDataToSelect(response.data || [], 'code', 'name')
}

const getLocationByAddress = async (address) => {
  const response = await $axios.post('location/by-address', {
    addressData: address,
  })

  const locations = _.get(response, 'data', [])

  _.forEach(locations, (item) => {
    const { target, code, data } = item
    const responseFormat = formatDataToSelect(data, 'code', 'name')

    switch (target) {
      case 'provinces':
        location.province_id = code
        break
      case 'districts':
        districts.value = responseFormat
        location.district_id = code
        break
      case 'wards':
        wards.value = responseFormat
        location.ward_id = code
        break
    }
  })
}

onMounted(async () => {
  getProvinces()
})
</script>
<template>
  <div class="checkout-address">
    <div class="d-flex items-center justify-between pb-4">
      <h3 class="title billing-title text-uppercase ls-10 pt-1 m-0">
        Địa chỉ giao hàng
      </h3>
      <a href="#" class="fs-15">Chỉnh sửa</a>
    </div>
    <div class="customer-address">
      <div class="row gutter-sm">
        <div class="col-xs-6">
          <IncludesInputComponent name="customer_name" label="Họ và tên *" />
        </div>
        <div class="col-xs-6">
          <IncludesInputComponent
            name="customer_phone"
            label="Số điện thoại *"
          />
        </div>
        <div class="col-xs-12">
          <IncludesInputComponent
            name="customer_email"
            label="Địa chỉ email *"
          />
        </div>
        <div class="col-xs-12 mb-5">
          <v-btn
            rounded="xl"
            prepend-icon="mdi-map-marker"
            @click="getGeolocation"
            :loading="isLoading"
          >
            <template v-slot:prepend>
              <v-icon color="warning"></v-icon>
            </template>

            Chọn từ vị trí
          </v-btn>
        </div>
      </div>
      <div class="row gutter-sm">
        <div class="col-md-4">
          <IncludesSelectComponent
            name="province_id"
            label="Tỉnh / Thành phố *"
            :items="provinces"
            :old-value="location.province_id"
            @on-change="handleLocationChange('districts', $event)"
          />
        </div>
        <div class="col-md-4">
          <IncludesSelectComponent
            :items="districts"
            name="district_id"
            label="Quận / Huyện *"
            :old-value="location.district_id"
            @on-change="handleLocationChange('wards', $event)"
          />
        </div>
        <div class="col-md-4">
          <IncludesSelectComponent
            :items="wards"
            name="ward_id"
            label="Phường / Xã *"
            :old-value="location.ward_id"
          />
        </div>

        <div class="col-md-12">
          <IncludesInputComponent
            name="shipping_address"
            label="Địa chỉ giao hàng *"
            typeInput="textarea"
            :old-value="location.shipping_address"
          />
        </div>
      </div>
    </div>

    <div class="customer-user d-none">
      <div>
        <div class="v2-checkout-address-inner">
          <div>
            <div class="v2-address-title-container">
              <span class="v2-address-title">Vũ Ngọc Tân</span>
              <span class="v2-mobile">0332225690</span>
            </div>
          </div>
          <div class="v2-address-info-item">
            <span
              class="v2-address-tag-label mr-2"
              style="
                background-image: linear-gradient(
                  -143deg,
                  rgb(255, 123, 83) 0%,
                  rgb(255, 75, 40) 100%
                );
              "
              >NHÀ RIÊNG</span
            >
            <span class="v2-address-info-address">
              Thôn cầu thăng long Cổng cụm 4 ngõ thứ 2, Xã Kim Nỗ, Huyện Đông
              Anh, Hà Nội
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
