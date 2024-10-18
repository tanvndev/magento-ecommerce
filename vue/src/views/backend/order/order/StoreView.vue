<template>
  <MasterLayout>
    <template #template>
      <div class="mx-10 h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" @on-save="onSubmit" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="18">
              <a-card class="mt-3" title="Danh sách sản phẩm">
                <AleartError :errors="state.errors" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <SearchProductView @on-save="handleSave" />
                  </a-col>
                </a-row>
              </a-card>
              <a-card class="mt-3" title="Thông tin đơn hàng">
                <a-row :gutter="[16, 16]" class="mt-3 flex justify-between">
                  <a-col :span="12">
                    <div class="mb-4">
                      <SelectComponent
                        name="payment_method_id"
                        label="Phương thức thanh toán"
                        :options="state.paymentMethods"
                        :required="true"
                        placeholder="Chọn phương thức thanh toán"
                      />
                    </div>
                    <div class="mb-4">
                      <SelectComponent
                        name="shipping_method_id"
                        label="Hình thức vận chuyển"
                        :options="state.shippingMethods"
                        :required="true"
                        placeholder="Chọn hình thức với chuyển"
                      />
                    </div>

                    <div class="mb-4">
                      <InputComponent
                        name="note"
                        type-input="textarea"
                        label="Ghi chú"
                        :show-count="false"
                        placeholder="Để lại lời nhắn"
                      />
                    </div>
                  </a-col>
                  <a-col>
                    <div class="mt-7 flex flex-col gap-3 text-[15px]">
                      <div class="d-flex items-center justify-end">
                        <span class="font-bold">Tạm tính</span>
                        <span class="w-[200px] text-right">
                          {{ formatCurrency(total_price || 20000000) }}
                        </span>
                      </div>

                      <div class="d-flex items-center justify-end">
                        <span class="font-bold">Phí vận chuyển</span>
                        <span class="w-[200px] text-right">
                          {{ formatCurrency(shipping_fee || 20000000) }}
                        </span>
                      </div>

                      <div class="d-flex items-center justify-end text-[16px]">
                        <span class="font-bold">Tổng cuối</span>
                        <span class="w-[200px] text-right font-bold">
                          {{ formatCurrency(final_price || 20000000) }}
                        </span>
                      </div>
                    </div>
                  </a-col>
                </a-row>
              </a-card>
            </a-col>

            <a-col :span="6">
              <SearchUser />
            </a-col>
          </a-row>

          <div class="fixed bottom-0 right-[19px] p-10">
            <a-button html-type="submit" type="primary" size="large">
              <i class="fas fa-save mr-2"></i>
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
import { formatCurrency, formatDataToSelect, formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';
import SearchProductView from './partials/SearchProductView.vue';
import SearchUser from './partials/SearchUser.vue';

// VARIABLES

const store = useStore();
const { getOne, create, update, messages, data, getAll } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);

// STATE
const state = reactive({
  endpoint: 'brands',
  pageTitle: 'Thêm mới đơn hàng',
  errors: {},
  products: [],
  paymentMethods: [],
  shippingMethods: []
});

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên đơn hàng không được để trống.')
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
  router.push({ name: 'brand.index' });
});

const handleSave = (data) => {
  state.products = data;
};

const getPaymentMethods = async () => {
  try {
    await getAll('payment-methods');
    state.paymentMethods = formatDataToSelect(data.value);
  } catch (error) {
    console.log(error);
  }
};

const getShippingMethod = async () => {
  try {
    await getAll('shipping-methods');
    state.shippingMethods = formatDataToSelect(data.value);
  } catch (error) {
    console.log(error);
  }
};

onMounted(() => {
  getPaymentMethods();
  getShippingMethod();
});
</script>
