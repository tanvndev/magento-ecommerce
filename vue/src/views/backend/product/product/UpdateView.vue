<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto mb-24">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="17">
              <!-- Thông tin chung -->
              <a-card class="mt-3" title="Thông tin sản phẩm">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <InputComponent
                      label="Tiêu đề sản phẩm"
                      :required="true"
                      name="name"
                      placeholder="Tiêu đề sản phẩm"
                    />
                  </a-col>
                  <a-col :span="24">
                    <EditorComponent name="description" label="Mô tả sản phẩm" />
                  </a-col>
                  <a-col :span="24">
                    <InputComponent
                      name="excerpt"
                      typeInput="textarea"
                      placeholder="Mô tả ngắn của sản phẩm"
                      label="Mô tả ngắn của sản phẩm"
                    />
                  </a-col>
                </a-row>
              </a-card>
            </a-col>
            <div class="hidden">
              <!-- Attribute -->
              <InputComponent name="attributes" />
              <InputComponent name="variants" />
            </div>

            <!-- Sidebar right -->
            <a-col :span="7">
              <a-card class="mt-3" title="Thương hiệu">
                <SelectComponent
                  name="brand_id"
                  :options="state.brands"
                  placeholder="Chọn thương hiệu sản phẩm"
                />
              </a-card>

              <a-card class="mt-3" title="Nhóm sản phẩm">
                <TreeSelectComponent
                  name="product_catalogue_id"
                  :treeDefaultExpandAll="true"
                  :options="state.productCatalogues"
                  placeholder="Chọn nhóm sản phẩm"
                />
              </a-card>
              <a-card class="mt-3" title="Loại sản phẩm">
                <SelectComponent
                  name="product_type"
                  label="Loại sản phẩm"
                  :required="true"
                  :options="PRODUCT_TYPE"
                  :showSearch="false"
                  tooltip-text="Sản phẩm đơn giản là sản phẩm có không có phiên bản. Sản phẩm biến thể có nhiều phiên bản khác nhau."
                  placeholder="Chọn loại sản phẩm"
                />
              </a-card>
            </a-col>

            <!-- Main data -->
            <ProductVariantView :variants="state.variants" />
            <!-- SEO -->

            <SEOComponent span="24" />
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
  EditorComponent,
  SEOComponent,
  SelectComponent,
  TreeSelectComponent
} from '@/components/backend';
import _ from 'lodash';
import { computed, onMounted, reactive, watch, watchEffect } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatDataToTreeSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';
import { PRODUCT_TYPE } from '@/static/constants';

// STATE
const state = reactive({
  endpoint: 'products',
  pageTitle: 'Cập nhập sản phẩm.',
  error: {},
  productCatalogues: [],
  brands: [],
  variants: []
});

const store = useStore();
const { getOne, getAll, update, messages, data } = useCRUD();

const id = computed(() => router.currentRoute.value.params.id || null);
const attributes = computed(() => store.getters['productStore/getAttributes']);
const variants = computed(() => store.getters['productStore/getVariants']);
const productType = computed(() => store.getters['productStore/getProductType']);
import ProductVariantView from './partials/ProductVariantView.vue';

const { handleSubmit, setValues, setFieldValue, errors } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tiêu đề sản phẩm không được để trống.'),
    product_type: yup.string().required('Loại sản phẩm không được để trống.'),
    product_catalogue_id: yup
      .mixed()
      .test(
        'is-string-or-array',
        'Vui lòng chọn nhóm sản phẩm.',
        (value) => typeof value === 'string' || (Array.isArray(value) && !_.isEmpty(value))
      )
      .required('Vui lòng chọn nhóm sản phẩm.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  if (productType.value == 'variable' && _.isEmpty(variants.value)) {
    return (state.error = { variants: 'Vui lòng tạo ít nhất một biến thể sản phẩm.' });
  }

  state.error = {};
  const response = await update(state.endpoint, id.value, values);
  if (!response) {
    return (state.error = formatMessages(messages.value));
  }

  state.error = {};
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  store.commit('productStore/removeAll');
  //   router.push({ name: 'product.index' });
});

watch(errors, (newErrors) => {
  state.error = newErrors;
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({
    name: data.value?.name,
    description: data.value?.description,
    excerpt: data.value?.excerpt,
    meta_title: data.value?.meta_title,
    meta_description: data.value?.meta_description,
    canonical: data.value?.canonical,
    product_type: data.value?.product_type,
    brand_id: data.value?.brand_id,
    product_catalogue_id: data.value?.product_catalogue_ids
  });

  if (!_.isEmpty(data.value?.variants)) {
    state.variants = data.value?.variants;
  }
};

watchEffect(() => {
  if (!_.isEmpty(attributes.value)) {
    setFieldValue('attributes', JSON.stringify(attributes.value));
  }
  if (!_.isEmpty(variants.value)) {
    setFieldValue('variants', JSON.stringify(variants.value));
  }
});

// LAY RA TOAN BO PRODUCT CATALOGUE
const getProductCatalogues = async () => {
  await getAll('products/catalogues');
  state.productCatalogues = formatDataToTreeSelect(data.value);
};

// LAY RA TOAN BO BRAND
const getBrands = async () => {
  await getAll('brands');
  state.brands = formatDataToSelect(data.value);
};

// LAY RA TOAN BO SUPPLIER

onMounted(async () => {
  getProductCatalogues();
  getBrands();
  if (id.value) {
    fetchOne();
  }
});
</script>
