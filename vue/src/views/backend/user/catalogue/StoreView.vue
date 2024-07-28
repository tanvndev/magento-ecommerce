<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-card class="mt-3">
            <AleartError :errors="errors" />
            <a-row :gutter="16">
              <a-col :span="8">
                <InputComponent name="name" label="Tên nhóm thành viên" :required="true" />
              </a-col>
              <a-col :span="8">
                <InputComponent name="code" label="Mã nhóm thành viên" :required="true" />
              </a-col>
              <a-col :span="8">
                <InputComponent
                  name="description"
                  label="Mô tả nhóm  thành viên"
                  :required="true"
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

const endpoint = 'users/catalogues';

const pageTitle = ref('Thêm mới nhóm thành viên');
const errors = ref({});

const store = useStore();
const { getOne, create, update, messages, data, loading } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên nhóm thành viên không được để trống.'),
    code: yup.string().required('Mã nhóm thành viên không được để trống.').min(3),
    description: yup.string().required('Mô tả nhóm thành viên không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  const response =
    id.value && id.value > 0
      ? await update(endpoint, id.value, values)
      : await create(endpoint, values);
  if (!response) {
    return (errors.value = formatMessages(messages.value));
  }

  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  errors.value = {};
  router.push({ name: 'user.catalogue.index' });
});

const fetchOne = async () => {
  await getOne(endpoint, id.value);
  setValues({
    name: data.value.name,
    code: data.value.code,
    description: data.value.description
  });
};

onMounted(() => {
  if (id.value && id.value > 0) {
    pageTitle.value = 'Cập nhập nhóm thành viên.';
    fetchOne();
  }
});
</script>
