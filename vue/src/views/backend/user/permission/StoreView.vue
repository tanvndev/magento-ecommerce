<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-card class="mt-3">
            <AleartError :errors="errors" />
            <a-row :gutter="16">
              <a-col :span="12">
                <InputComponent
                  name="name"
                  label="Tên quyền người dùng"
                  :required="true"
                  placeholder="Nếu tạo nhanh CRUD thì điền tên kiểu gì cũng được."
                />
              </a-col>
              <a-col :span="12">
                <InputComponent
                  name="canonical"
                  label="Canonical"
                  :required="true"
                  placeholder="Tạo nhanh CRUD ví dụ: users:CRUD:thành viên, users.catalogue:CRU:giáo viên, ..."
                />
              </a-col>
            </a-row>
          </a-card>

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
  InputComponent
} from '@/components/backend';
import { computed, onMounted, ref } from 'vue';
import { useForm } from 'vee-validate';
import { formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

const pageTitle = ref('Thêm mới quyền người dùng');
const errors = ref({});
const store = useStore();
const endpoint = 'permissions';
const { getOne, create, update, messages, data, loading } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên quyền người dùng không được để trống.'),
    canonical: yup.string().required('Canonical không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  console.log(values);
  const response =
    id.value && id.value > 0
      ? await update(endpoint, id.value, values)
      : await create(endpoint, values);
  if (!response) {
    return (errors.value = formatMessages(messages.value));
  }

  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  errors.value = {};
  router.push({ name: 'permission.index' });
});

const fetchOne = async () => {
  await getOne(endpoint, id.value);
  setValues({ name: data.value.name, canonical: data.value.canonical });
};

onMounted(() => {
  if (id.value && id.value > 0) {
    pageTitle.value = 'Cập nhập quyền người dùng.';
    fetchOne();
  }
});
</script>
