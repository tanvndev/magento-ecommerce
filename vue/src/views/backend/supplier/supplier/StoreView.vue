<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="16" class="mx-auto">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="errors" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="12">
                    <InputComponent
                      name="company_name"
                      label="Tên công ty nhà cung cấp"
                      :required="true"
                      placeholder="Tên công ty nhà cung cấp"
                    />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent
                      name="contact_name"
                      label="Tên nhà cung cấp"
                      :required="true"
                      placeholder="Tên nhà cung cấp"
                    />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent
                      name="contact_email"
                      label="Địa chỉ email"
                      :required="true"
                      placeholder="Địa chỉ email nhà cung cấp"
                    />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent
                      name="contact_phone"
                      label="Số điện thoại"
                      :required="true"
                      placeholder="Số điện thoại nhà cung cấp"
                    />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent
                      name="address"
                      label="Địa chỉ nhà cung cấp"
                      :required="true"
                      placeholder="Địa chỉ nhà cung cấp"
                    />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent
                      type-input="textarea"
                      name="description"
                      label="Mô tả"
                      placeholder="Mô tả nhà cung cấp"
                    />
                  </a-col>
                </a-row>
              </a-card>
            </a-col>
          </a-row>

          <div class="fixed bottom-0 right-[19px] p-10">
            <a-button html-type="submit" type="primary">
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
  InputComponent
} from '@/components/backend';
import { computed, onMounted, ref } from 'vue';
import { useForm } from 'vee-validate';
import { formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

// VARIABLES
const pageTitle = ref('Thêm mới nhà cung cấp');
const errors = ref({});
const store = useStore();
const endpoint = 'suppliers';
const { getOne, create, update, messages, data } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    company_name: yup.string().required('Tên công ty nhà cung cấp không được để trống.'),
    contact_name: yup.string().required('Tên nhà cung cấp không được để trống.'),
    address: yup.string().required('Địa chỉ nhà cung cấp không được để trống.'),
    contact_email: yup
      .string()
      .email('Email nhà cung cấp không đúng định dạng.')
      .required('Email nhà cung cấp không được để trống.'),
    contact_phone: yup
      .string()
      .required('Số điện thoại nhà cung cấp không được để trống.')
      .matches(/(0)[0-9]{9}/, 'Số điện thoại không đúng định dạng.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  console.log(1234);
  errors.value = {};
  const response =
    id.value && id.value > 0
      ? await update(endpoint, id.value, values)
      : await create(endpoint, values);
  if (!response) {
    return (errors.value = formatMessages(messages.value));
  }

  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  errors.value = {};
  router.push({ name: 'supplier.index' });
});

const fetchOne = async () => {
  await getOne(endpoint, id.value);
  setValues({
    company_name: data.value.company_name,
    description: data.value.description,
    contact_name: data.value.contact_name,
    contact_email: data.value.contact_email,
    contact_phone: data.value.contact_phone,
    address: data.value.address
  });
};

onMounted(() => {
  if (id.value && id.value > 0) {
    pageTitle.value = 'Cập nhập nhà cung cấp.';
    fetchOne();
  }
});
</script>
