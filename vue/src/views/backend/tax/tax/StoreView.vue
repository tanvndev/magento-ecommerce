<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="16" class="mx-auto">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="state.errors" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <InputComponent
                      name="name"
                      label="Tên thuế suất"
                      :required="true"
                      placeholder="Tên thuế suất"
                    />
                  </a-col>
                  <a-col :span="19">
                    <InputComponent
                      name="code"
                      label="Mã thuế suất"
                      placeholder="Mã thuế suất"
                      :required="true"
                    />
                  </a-col>

                  <a-col :span="5">
                    <InputNumberComponent
                      type-input="percent"
                      name="rate"
                      label="Tỉ lệ thuế suất"
                      placeholder="Tỉ lệ thuế suất"
                      :required="true"
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
  InputComponent,
  InputNumberComponent
} from '@/components/backend';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';

const store = useStore();
const { getOne, create, update, messages, data } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

// STATE
const state = reactive({
  endpoint: 'taxes',
  pageTitle: 'Thêm mới thuế suất',
  errors: {}
});

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên thuế suất không được để trống.'),
    code: yup.string().required('Mã thuế suất không được để trống.'),
    rate: yup.string().required('Tỉ lệ thuế suất không được để trống.')
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
  router.push({ name: 'tax.index' });
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({
    name: data.value.name,
    code: data.value.code,
    rate: data.value.rate
  });
};

onMounted(() => {
  if (id.value && id.value > 0) {
    state.pageTitle = 'Cập nhập thuế suất.';
    fetchOne();
  }
});
</script>
