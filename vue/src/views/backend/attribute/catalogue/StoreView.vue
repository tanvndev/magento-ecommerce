<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-card class="mt-3" title="Dữ liệu nhóm thuộc tính">
            <AleartError :errors="state.errors" />
            <a-row :gutter="[16, 16]">
              <a-col :span="12">
                <InputComponent
                  name="name"
                  label="Tên nhóm thuộc tính"
                  :required="true"
                  placeholder="Tên nhóm thuộc tính"
                />
              </a-col>
              <a-col :span="12">
                <InputComponent
                  name="code"
                  label="Mã nhóm thuộc tính"
                  :required="true"
                  placeholder="Mã nhóm thuộc tính"
                />
              </a-col>
              <a-col :span="24">
                <InputComponent
                  typeInput="textarea"
                  name="description"
                  label="Mô tả nhóm thuộc tính"
                  placeholder="Mô tả nhóm thuộc tính"
                />
              </a-col>
            </a-row>
          </a-card>

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
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

// STATE

const state = reactive({
  endpoint: 'attributes/catalogues',
  pageTitle: 'Thêm mới nhóm thuộc tính',
  errors: {}
});

const store = useStore();
const { getOne, create, update, messages, data } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên nhóm thuộc tính không được để trống.'),
    code: yup.string().required('Mã nhóm thuộc tính không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  const response =
    id.value && id.value > 0
      ? await update(state.endpoint, id.value, values)
      : await create(state.endpoint, values);
  if (!response) {
    return (state.errors = formatMessages(messages.value));
  }

  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  state.errors = {};
  router.push({ name: 'attribute.catalogue.index' });
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({ name: data.value.name, description: data.value.description, code: data.value.code });
};

onMounted(() => {
  if (id.value && id.value > 0) {
    state.pageTitle = 'Cập nhập nhóm thuộc tính.';
    fetchOne();
  }
});
</script>
