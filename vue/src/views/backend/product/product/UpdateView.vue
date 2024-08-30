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
                <div>
                  <SelectComponent
                    name="product_type"
                    label="Loại sản phẩm"
                    :required="true"
                    :options="PRODUCT_TYPE"
                    :showSearch="false"
                    tooltip-text="Lưu ý bạn chỉ có thể cập nhập từ sản phẩm ''đơn sản'' sang sản phẩm ''biến thể'' không để cập nhập ngược lại, các phiên bản cũ sẽ bị xóa vĩnh viễn nếu bạn cập nhập từ sản phẩm ''đơn giản'' sang ''biến thể''."
                    placeholder="Chọn loại sản phẩm"
                    @on-change="handleProductType"
                  />
                </div>
              </a-card>
            </a-col>

            <a-col span="24" class="mt-3">
              <!-- Main data -->
              <ProductVariantView
                :variants="state.variants"
                :attribute-data="state.attributeData"
                :product-type="state.productType"
                :attribute-enable-old="state.attributeEnableOld"
                :attribute-enable-ids="state.attributeEnableIds"
                @onReload="fetchOne"
              />
            </a-col>

            <a-col span="9">
              <!-- ProductAttribute -->
              <ProductAttributeView
                :attribute-data="state.attributeData"
                :attribute-not-enable-old="state.attributeNotEnableOld"
                :attribute-not-enable-ids="state.attributeNotEnableIds"
              />
            </a-col>

            <!-- SEO -->
            <a-col span="15">
              <SEOComponent />
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
  EditorComponent,
  SEOComponent,
  SelectComponent,
  TreeSelectComponent
} from '@/components/backend';
import _ from 'lodash';
import { computed, onMounted, reactive, watch } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatDataToTreeSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';
import { PRODUCT_TYPE } from '@/static/constants';
import ProductVariantView from './partials/ProductVariantView.vue';
import { message } from 'ant-design-vue';
import ProductAttributeView from './partials/ProductAttributeView.vue';

// STATE
const state = reactive({
  endpoint: 'products',
  pageTitle: 'Cập nhập sản phẩm.',
  error: {},
  productCatalogues: [],
  brands: [],
  variants: [],
  attributeData: [],
  attributeNotEnableOld: [],
  attributeNotEnableIds: [],
  attributeEnableOld: [],
  attributeEnableIds: [],
  productType: ''
});

const store = useStore();
const { getOne, getAll, update, messages, data } = useCRUD();

const id = computed(() => router.currentRoute.value.params.id || null);
const { handleSubmit, setValues, errors } = useForm({
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
  state.error = {};
  const response = await update(state.endpoint, id.value, values);
  if (!response) {
    return (state.error = formatMessages(messages.value));
  }

  state.error = {};
  message.success(messages.value);
  store.commit('productStore/removeAll');
  //   router.push({ name: 'product.index' });
});

watch(errors, (newErrors) => {
  state.error = newErrors;
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  const productType = data.value?.product_type;
  setValues({
    name: data.value?.name,
    description: data.value?.description,
    excerpt: data.value?.excerpt,
    meta_title: data.value?.meta_title,
    meta_description: data.value?.meta_description,
    canonical: data.value?.canonical,
    product_type: productType,
    brand_id: data.value?.brand_id,
    product_catalogue_id: data.value?.product_catalogue_ids,
    attribute_id: data.value?.attribute_not_enabled_ids
  });

  if (!_.isEmpty(data.value?.variants)) {
    state.variants = data.value?.variants;
  }

  if (!_.isEmpty(productType)) {
    state.productType = productType;
    store.commit('productStore/setProductType', productType);
  }

  if (!_.isEmpty(data.value?.attribute_not_enabled_ids)) {
    state.attributeNotEnableIds = data.value?.attribute_not_enabled_ids;
  }

  if (!_.isEmpty(data.value?.attribute_not_enabled)) {
    state.attributeNotEnableOld = data.value?.attribute_not_enabled;
  }

  if (!_.isEmpty(data.value?.attribute_enabled)) {
    state.attributeEnableOld = data.value?.attribute_enabled;
  }

  if (!_.isEmpty(data.value?.attribute_enabled_ids)) {
    state.attributeEnableIds = data.value?.attribute_enabled_ids;
  }
};

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

const handleProductType = (value) => {
  state.productType = value;
};

const getAttributes = async () => {
  await getAll('attributes');
  state.attributeData = data.value;
};

onMounted(async () => {
  getProductCatalogues();
  getBrands();
  getAttributes();
  if (id.value) {
    fetchOne();
  }
});
</script>
