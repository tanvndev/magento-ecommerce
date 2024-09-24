<template>
  <!-- Start of Main -->
  <main class="main checkout">
    <!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav">
      <div class="container">
        <ul class="breadcrumb shop-breadcrumb bb-no">
          <li class="passed">
            <NuxtLink to="cart">Giỏ hàng</NuxtLink>
          </li>
          <li class="active">
            <NuxtLink to="checkout">Thanh toán</NuxtLink>
          </li>
          <li>
            <a href="#">Hoàn tất đơn hàng</a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of PageContent -->
    <div class="page-content checkout-content-wrapper">
      <form @submit.prevent="onSubmit">
        <div class="container">
          <div class="coupon-toggle">
            Bạn có mã giảm giá?
            <a
              @click.prevent="showApplyVoucher = !showApplyVoucher"
              href="#"
              class="show-coupon font-weight-bold text-uppercase text-dark"
              >Nhập mã code</a
            >
          </div>
          <div class="coupon-content mb-4" v-show="showApplyVoucher">
            <p>
              Nếu bạn có mã giảm giá, vui lòng áp dụng bên dưới. Bạn có thể xem
              mã giảm giá
              <NuxtLink
                to="/voucher"
                target="_blank"
                title="Xem mã giảm giá tại đây"
                >tại đây</NuxtLink
              >
            </p>
            <div class="input-wrapper-inline">
              <input
                type="text"
                name="Mã giảm giá"
                class="form-control form-control-md mr-1 mb-2"
                placeholder="Mã giảm giá"
              />
              <button
                type="button"
                class="btn button btn-rounded btn-coupon mb-2"
              >
                Áp Dụng Mã
              </button>
            </div>
          </div>
          <div class="row mb-9">
            <div class="col-lg-7 pr-lg-4 mb-4 main-content" ref="mainContent">
              <!-- Checkout address -->
              <CheckoutAddress @on-location="handleLocationChange" />

              <!-- Shipping method -->
              <CheckoutShippingMethod />

              <!-- Checkout product -->
              <CheckoutProduct />

              <div class="form-group mt-3">
                <div class="col-md-12">
                  <IncludesInputComponent
                    :row-height="20"
                    :rows="2"
                    type-input="textarea"
                    name="note"
                    label="Lời nhắn"
                    hint="Lời nhắn về đơn hàng của bạn, ví dụ ghi chú đặc biệt về việc giao hàng"
                  />
                </div>
              </div>
            </div>
            <div class="col-lg-5 mb-4">
              <div
                class="order-summary-wrapper sticky-sidebar"
                ref="secondaryContent"
                :style="sidebarStyle"
              >
                <CheckoutSidebar />
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- End of PageContent -->
  </main>
  <!-- End of Main -->
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useForm } from 'vee-validate'
import { useCartStore } from '#imports'

const { $axios } = useNuxtApp()
const cartStore = useCartStore()
const router = useRouter()
const showApplyVoucher = ref(false)
const sidebarStyle = ref({})
const mainContent = ref(null)
const secondaryContent = ref(null)
const stickyOffset = 20
const carts = computed(() => cartStore.getCartSelected)

const { handleSubmit, setFieldValue } = useForm({
  validationSchema: {
    customer_name(value) {
      if (value) return true
      return 'Vui lòng nhập họ và tên.'
    },
    shipping_address(value) {
      if (value) return true
      return 'Vui lòng nhập địa chỉ.'
    },
    province_id(value) {
      if (value) return true
      return 'Vui lòng chọn Tỉnh / Thành phố.'
    },
    district_id(value) {
      if (value) return true
      return 'Vui lòng chọn Quận / Huyện.'
    },
    ward_id(value) {
      if (value) return true
      return 'Vui lòng chọn Phường / Xã.'
    },
    customer_phone(value) {
      if (!value) return 'Số điện thoại không được để trống.'
      if (/^(0[0-9]{9})$/.test(value)) return true
      return 'Số điện thoại không đúng định dạng.'
    },
    customer_email(value) {
      if (!value) return 'Email không được để trống.'
      if (/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value))
        return true
      return 'Email không đúng định dạng.'
    },
  },
})

const onSubmit = handleSubmit(async (values) => {
  const response = await $axios.post('/orders', values)

  if (response.status == 'success') {
    return (location.href = response?.url)
  }
})

const handleLocationChange = (target) => {
  if (target === 'districts') {
    setFieldValue('ward_id', '')
    setFieldValue('district_id', '')
  } else if (target === 'wards') {
    setFieldValue('ward_id', '')
  }
}

const handleScroll = () => {
  const scrollY = window.scrollY
  const mainRect = mainContent.value?.getBoundingClientRect()
  const secondaryRect = secondaryContent.value?.getBoundingClientRect()

  if (mainRect < secondaryRect + 100) {
    return
  }

  const colRect = document
    .querySelector('.main-content')
    ?.getBoundingClientRect()

  if (scrollY > stickyOffset && colRect) {
    if (scrollY < colRect.bottom + window.scrollY) {
      const newBottom = Math.max(
        window.innerHeight - mainRect.bottom - stickyOffset,
        0
      )
      sidebarStyle.value = {
        position: 'fixed',
        bottom: `${newBottom + 20}px`,
        width: '505px',
        borderBottom: '1px solid rgb(238, 238, 238)',
      }
    } else {
      sidebarStyle.value = {}
    }
  } else {
    sidebarStyle.value = {}
  }
}

onBeforeMount(() => {
  if (!carts.value.length) {
    router.push({ name: 'cart' })
  }
})

onMounted(async () => {
  window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped></style>
