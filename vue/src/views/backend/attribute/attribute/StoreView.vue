<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-card class="mt-3" title="Dữ liệu thuộc tính">
            <AleartError :errors="state.errors" />
            <a-row :gutter="[16, 10]">
              <a-col :span="16">
                <InputComponent
                  name="name"
                  label="Tên thuộc tính"
                  :required="true"
                  placeholder="Thêm nhiều cùng lúc ví dụ: Màu hồng|Màu đen|..."
                />
              </a-col>
              <a-col :span="8">
                <SelectComponent
                  name="attribute_catalogue_id"
                  label="Nhóm thuộc tính"
                  :options="state.attributeCatalogues"
                  placeholder="Chọn nhóm thuộc tính"
                  :required="true"
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
  InputComponent,
  SelectComponent
} from '@/components/backend';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { formatDataToSelect, formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

// STATE

const state = reactive({
  endpoint: 'attributes',
  pageTitle: 'Thêm mới thuộc tính',
  attributeCatalogues: [],
  errors: {}
});

const store = useStore();
const { getOne, getAll, create, update, messages, data } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên thuộc tính không được để trống.'),
    attribute_catalogue_id: yup.string().required('Vui lòng chọn nhóm thuộc tính.')
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
  router.push({ name: 'attribute.index' });
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({ name: data.value.name, attribute_catalogue_id: data.value.attribute_catalogue_id });
};

const getAttributeCatalogues = async () => {
  await getAll('attributes/catalogues');
  state.attributeCatalogues = formatDataToSelect(data.value, 'id', 'name');
};

onMounted(() => {
  getAttributeCatalogues();
  if (id.value && id.value > 0) {
    state.pageTitle = 'Cập nhập thuộc tính.';
    fetchOne();
  }
});
</script>
