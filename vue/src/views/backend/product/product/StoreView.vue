<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto mb-24">
        <BreadcrumbComponent :titlePage="pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="17">
              <!-- Thông tin chung -->
              <a-card class="mt-3" title="Thông tin sản phẩm">
                <AleartError :errors="error" />
                <a-row :gutter="[16, 10]">
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
                  name="short_description"
                  typeInput="textarea"
                  label="Mô tả ngắn của sản phẩm"
                />
              </a-card>
            </a-col>

            <div class="hidden">
              <!-- Attribute -->
              <InputComponent name="attributes" />
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
  SelectComponent,
  EditorComponent,
  InputFinderComponent
} from '@/components/backend';
import _ from 'lodash';
import MainComponent from './partials/MainComponent.vue';
import SidebarComponent from './partials/SidebarComponent.vue';
import { computed, onMounted, ref, watch } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatDataToSelect, formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useLocation, useCRUD } from '@/composables';

const endpoint = 'products';

const pageTitle = ref('Thêm mới thành viên');
const error = ref({});
const userCatalogues = ref([]);

const store = useStore();
const { getOne, getAll, create, update, messages, data } = useCRUD();

const id = computed(() => router.currentRoute.value.params.id || null);
const attributes = computed(() => store.getters['productStore/getAttributes']);

const { handleSubmit, setValues, setFieldValue } = useForm({
  validationSchema: yup.object({
    // fullname: yup.string().required('Họ tên thành viên không được để trống.'),
  })
});

const onSubmit = handleSubmit(async (values) => {
  console.log(values);
  const response =
    id.value && id.value > 0
      ? await update(endpoint, id.value, values)
      : await create(endpoint, values);
  if (!response) {
    return (error.value = formatMessages(messages.value));
  }
  // store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  // error.value = {};
  // router.push({ name: 'user.index' });
});

const fetchOne = async () => {
  await getOne(endpoint, id.value);
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

watch(attributes, () => {
  if (!_.isEmpty(attributes.value)) {
    setFieldValue('attributes', JSON.stringify(attributes.value));
  }
});

onMounted(async () => {
  if (id.value) {
    fetchOne();
    pageTitle.value = 'Cập nhập thành viên.';
  }
});
</script>
