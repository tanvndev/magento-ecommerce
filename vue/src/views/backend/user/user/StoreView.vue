<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="12">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="12">
                    <InputComponent label="Họ tên thành viên" :required="true" name="fullname" />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent label="Địa chỉ email" :required="true" name="email" />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent label="Số điện thoại" :required="true" name="phone" />
                  </a-col>

                  <a-col :span="12" v-if="!id">
                    <InputComponent
                      type="password"
                      label="Mật khẩu"
                      :required="true"
                      name="password"
                    />
                  </a-col>

                  <a-col :span="12">
                    <SelectComponent
                      label="Nhóm thành viên"
                      name="user_catalogue_id"
                      placeholder="Chọn nhóm thành viên"
                      :options="state.userCatalogues"
                      :required="true"
                    />
                  </a-col>
                  <a-col :span="!id ? 12 : 24">
                    <label for="image" class="mb-2 block text-sm font-medium text-gray-900"
                      >Ảnh đại diện</label
                    >
                    <InputFinderComponent :multipleFile="false" name="image" />
                  </a-col>
                </a-row>
              </a-card>
            </a-col>
            <a-col :span="12">
              <a-card class="mt-3" title="Địa chỉ">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 15]">
                  <a-col :span="8">
                    <SelectComponent
                      label="Quận/Thành phố"
                      name="province_id"
                      placeholder="Chọn Tỉnh/Thành phố"
                      :options="provinces"
                      @onChange="getLocation('districts', $event)"
                    />
                  </a-col>

                  <a-col :span="8">
                    <SelectComponent
                      label="Quận/Huyện"
                      name="district_id"
                      placeholder="Chọn Quận/Huyện"
                      :options="districts"
                      @onChange="getLocation('wards', $event)"
                    />
                  </a-col>

                  <a-col :span="8">
                    <SelectComponent
                      label="Phường/Xã"
                      name="ward_id"
                      placeholder="Chọn Phường/Xã"
                      :options="wards"
                    />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent label="Địa chỉ" name="address" />
                  </a-col>
                </a-row>
              </a-card>
            </a-col>
          </a-row>

          <div class="fixed bottom-0 right-[19px] p-10">
            <a-button html-type="submit" :loading="loading" type="primary">
              <i class="far fa-save mr-2"></i>
              <span>Lưu thông tin</span>
            </a-button>
          </div>
        </form>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import {
  MasterLayout,
  BreadcrumbComponent,
  AleartError,
  InputComponent,
  SelectComponent,
  InputFinderComponent
} from '@/components/backend';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useLocation, useCRUD } from '@/composables';

const store = useStore();
const { getOne, getAll, create, update, messages, data, loading } = useCRUD();
const { getProvinces, getLocations, provinces, districts, wards } = useLocation();

// STATE
const state = reactive({
  userCatalogues: [],
  error: {},
  endpoint: 'users',
  pageTitle: 'Thêm mới thành viên'
});

const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues, setFieldValue } = useForm({
  validationSchema: yup.object({
    fullname: yup.string().required('Họ tên thành viên không được để trống.'),
    email: yup.string().email('Email không đúng định dạng.').required('Email không được để trống.'),
    phone: yup
      .string()
      .required('Số điện thoại không được để trống.')
      .matches(/(0)[0-9]{9}/, 'Số điện thoại không đúng định dạng.'),
    user_catalogue_id: yup.number().required('Vui lòng chọn nhóm thành viên.'),
    password: id.value
      ? yup.string().nullable()
      : yup
          .string()
          .required('Mật khẩu bắt buộc phải nhập.')
          .min('6', 'Mật khẩu tối thiểu 6 kí tự.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  const response =
    id.value && id.value > 0
      ? await update(state.endpoint, id.value, values)
      : await create(state.endpoint, values);
  if (!response) {
    return (state.error = formatMessages(messages.value));
  }
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  state.error = {};
  router.push({ name: 'user.index' });
});

const getCatalogues = async () => {
  await getAll('users/catalogues');
  state.userCatalogues = formatDataToSelect(data.value);
};

const getLocation = async (target, location_id) => {
  if (target === 'districts') {
    setFieldValue('district_id', null);
    setFieldValue('ward_id', null);
  } else if (target === 'wards') {
    setFieldValue('ward_id', null);
  }
  if (location_id && target) {
    await getLocations(target, location_id);
  }
};

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({
    fullname: data.value?.fullname,
    email: data.value?.email,
    user_catalogue_id: data.value?.user_catalogue_id,
    phone: data.value?.phone,
    address: data.value?.address,
    province_id: data.value?.province_id,
    district_id: data.value?.district_id,
    ward_id: data.value?.ward_id,
    image: data.value?.image
  });
};

onMounted(async () => {
  if (id.value) {
    fetchOne();
    state.pageTitle = 'Cập nhập thành viên.';
  }
  getCatalogues();
  getProvinces();
});
</script>
