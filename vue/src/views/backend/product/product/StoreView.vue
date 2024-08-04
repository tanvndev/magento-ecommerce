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
                </a-row>
              </a-card>

              <!-- Album -->
              <a-card class="mt-3" title="Thư viện sản phẩm">
                <InputFinderComponent :multipleFile="true" name="album" />
              </a-card>

              <!-- Du lieu san pham -->
              <MainComponent />

              <!-- Mo ta ngan san pham -->
              <a-card class="mt-3" title="Mô tả ngắn của sản phẩm">
                <InputComponent
                  name="excerpt"
                  typeInput="textarea"
                  label="Mô tả ngắn của sản phẩm"
                />
              </a-card>
            </a-col>

            <div class="hidden">
              <!-- Attribute -->
              <InputComponent name="attributes" />
              <InputComponent name="variants" />
            </div>

            <!-- Sidebar right -->
            <SidebarComponent />
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
  InputFinderComponent
} from '@/components/backend';
import _ from 'lodash';
import MainComponent from './partials/MainComponent.vue';
import SidebarComponent from './partials/SidebarComponent.vue';
import { computed, onMounted, reactive, watch } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

// STATE
const state = reactive({
  endpoint: 'products',
  pageTitle: 'Thêm mới thành viên',
  error: {},
  userCatalogues: []
});

const store = useStore();
const { getOne, create, update, messages, data } = useCRUD();

const id = computed(() => router.currentRoute.value.params.id || null);
const attributes = computed(() => store.getters['productStore/getAttributes']);
const variants = computed(() => store.getters['productStore/getVariants']);

const { handleSubmit, setValues, setFieldValue } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tiêu đề sản phẩm không được để trống.'),
    product_type: yup.string().required('Loại sản phẩm không được để trống.'),
    // image: yup.string().required('Ảnh sản phẩm không được để trống.'),
    // album: yup.string().required('Thư viện sản phẩm không được để trống.'),
    product_catalogue_id: yup.string().required('Vui lòng chọn nhóm sản phẩm.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  state.error = {};
  const response =
    id.value && id.value > 0
      ? await update(state.endpoint, id.value, values)
      : await create(state.endpoint, values);
  if (!response) {
    return (state.error = formatMessages(messages.value));
  }
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  router.push({ name: 'product.index' });
});

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

watch((attributes, variants), () => {
  if (!_.isEmpty(attributes.value)) {
    setFieldValue('attributes', JSON.stringify(attributes.value));
  }
  if (!_.isEmpty(variants.value)) {
    setFieldValue('variants', JSON.stringify(variants.value));
  }
});

onMounted(async () => {
  if (id.value) {
    fetchOne();
    state.pageTitle = 'Cập nhập thành viên.';
  }
});
</script>
