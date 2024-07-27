<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="16">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="errors" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="10">
                    <InputComponent
                      name="name"
                      label="Tên nhóm sản phẩm"
                      :required="true"
                      placeholder="Tên nhóm sản phẩm"
                    />
                  </a-col>
                  <a-col :span="10">
                    <InputComponent
                      name="canonical"
                      label="Đường dẫn nhóm sản phẩm"
                      placeholder="Tự động tạo nếu không nhập"
                    />
                  </a-col>
                  <a-col :span="4">
                    <InputNumberComponent
                      name="order"
                      label="Vị trí nhóm sản phẩm"
                      placeholder="Vị trí"
                    />
                  </a-col>
                  <a-col :span="24">
                    <InputComponent
                      typeInput="textarea"
                      name="description"
                      label="Mô tả nhóm sản phẩm"
                      placeholder="Tạo mô tả cho nhóm sản phẩm"
                    />
                  </a-col>
                </a-row>
              </a-card>
            </a-col>

            <a-col :span="8">
              <a-card class="mt-3" title="Ảnh danh mục">
                <InputFinderComponent name="image" />
              </a-card>

              <a-card class="mt-3">
                <template #title>
                  <span>
                    Danh mục cha
                    <small class="text-red-500">(Không chọn mặc định là danh mục cha)</small>
                  </span>
                </template>
                <TreeSelectComponent
                  name="parent_id"
                  :options="productCatalogues"
                  :placeholder="'Chọn danh mục cha'"
                />
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
  InputComponent,
  InputFinderComponent,
  TreeSelectComponent,
  InputNumberComponent
} from '@/components/backend';
import { computed, onMounted, ref } from 'vue';
import { useForm } from 'vee-validate';
import { formatDataToTreeSelect, formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

// VARIABLES
const pageTitle = ref('Thêm mới nhóm sản phẩm');
const errors = ref({});
const store = useStore();
const endpoint = 'products/catalogues';
const productCatalogues = ref();
const { getOne, create, update, getAll, messages, data } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên nhóm sản phẩm không được để trống.')
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
  router.push({ name: 'product.catalogue.index' });
});

const fetchOne = async () => {
  await getOne(endpoint, id.value);
  setValues({
    name: data.value.name,
    description: data.value.description,
    canonical: data.value.canonical,
    order: data.value.order,
    parent_id: data.value.parent_id,
    image: data.value.image
  });
};

const getProductCatalogues = async () => {
  await getAll('products/catalogues');
  productCatalogues.value = formatDataToTreeSelect(data.value);
};

onMounted(() => {
  if (id.value && id.value > 0) {
    pageTitle.value = 'Cập nhập nhóm sản phẩm.';
    fetchOne();
  }
  getProductCatalogues();
});
</script>
