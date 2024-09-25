<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto mb-10 min-h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16" v-if="order">
            <a-col :span="17">
              <a-card class="mt-3">
                <template #title> Đơn hàng #10000048 </template>
                <AleartError :errors="state.errors" />

                <a-row
                  v-for="item in order?.order_items"
                  :key="item.id"
                  :gutter="16"
                  class="mb-4 items-center border-b pb-4"
                >
                  <a-col :span="15">
                    <div class="d-flex items-center">
                      <div class="mr-2">
                        <img class="h-[60px] w-[60px] object-contain" :src="item.image" alt="" />
                      </div>
                      <div>
                        <RouterLink
                          :to="`/product/update/${item.product_id}?variant_id=${item.product_variant_id}`"
                          class="mb-1 block text-primary-500"
                          >{{ item.product_variant_name }}</RouterLink
                        >
                        <span class="text-sm text-gray-500"
                          >Phân loại: {{ item.attribute_values }}</span
                        >
                      </div>
                    </div>
                  </a-col>
                  <a-col :span="4">
                    <div class="text-left">
                      <span class="block">{{ formatCurrency(item.sale_price || item.price) }}</span>
                      <del v-if="item.sale_price">{{ formatCurrency(item.price) }}</del>
                    </div>
                  </a-col>
                  <a-col :span="1">
                    <span class="block text-center">x{{ item.quantity }}</span>
                  </a-col>
                  <a-col :span="4">
                    <div class="text-right">
                      <span class="block">{{
                        formatCurrency((item.sale_price || item.price) * item.quantity)
                      }}</span>
                    </div>
                  </a-col>
                </a-row>
                <div class="flex flex-col gap-3 text-[15px]" v-if="order">
                  <div class="d-flex items-center justify-end">
                    <span class="font-bold">Tạm tính</span>
                    <span class="w-[300px] text-right">
                      {{ formatCurrency(order?.total_price) }}
                    </span>
                  </div>
                  <div class="d-flex items-center justify-end" v-if="order?.discount">
                    <span class="font-bold">Giảm giá</span>
                    <span class="w-[300px] text-right">
                      {{ formatCurrency(order?.discount) }}
                    </span>
                  </div>
                  <div class="d-flex items-center justify-end">
                    <span class="font-bold">Phí vận chuyển</span>
                    <span class="w-[300px] text-right">
                      {{ formatCurrency(order?.shipping_fee) }}
                    </span>
                  </div>
                  <div class="d-flex items-center justify-end">
                    <span class="font-bold">Phương thức thanh toán</span>
                    <span class="w-[300px] text-right">{{
                      order?.additional_details?.payment_method?.name
                    }}</span>
                  </div>
                  <div class="d-flex items-center justify-end">
                    <span class="font-bold">Trạng thái thanh toán</span>
                    <div class="w-[300px] text-right">
                      <a-tag :color="order?.payment_status_color" class="-mr-1">
                        {{ order?.payment_status }}
                      </a-tag>
                    </div>
                  </div>
                  <div class="d-flex items-center justify-end">
                    <span class="font-bold">Tổng cuối</span>
                    <span class="w-[300px] text-right">
                      {{ formatCurrency(order?.final_price) }}
                    </span>
                  </div>
                </div>

                <a-divider />
                <div class="text-right">
                  <a-button size="large" class="mr-3">
                    <i class="fas fa-print mr-2"></i>
                    In đơn hàng
                  </a-button>
                  <a-button size="large">
                    <i class="fas fa-download mr-2"></i>
                    Tải về đơn hàng
                  </a-button>
                </div>

                <div class="ml-auto mt-6 w-[400px]">
                  <label class="mb-2 block text-[#222]">Ghi chú</label>
                  <a-textarea
                    placeholder="Autosize height with minimum and maximum number of lines"
                    :auto-size="{ minRows: 3, maxRows: 5 }"
                  />
                  <a-button size="large" class="mt-3"> Cập nhập </a-button>
                </div>
                <a-divider />
                <div class="flex items-center justify-between">
                  <span class="uppercase">
                    <i
                      class="fas fa-shopping-basket mr-2"
                      v-if="order?.order_status_code == ORDER_STATUS[0].value"
                    ></i>
                    <i class="fas fa-check mr-2 text-green-500" v-else></i>
                    {{ order?.order_status }}
                  </span>
                  <a-button size="large" type="primary"> Cập nhập </a-button>
                </div>
                <a-divider />
                <div class="flex items-center justify-between">
                  <span class="uppercase">
                    <i
                      class="fas fa-credit-card-front mr-2"
                      v-if="order?.payment_status_code == PAYMENT_STATUS[0].value"
                    ></i>
                    <i class="fas fa-check mr-2 text-green-500" v-else></i>
                    {{ order?.payment_status }}
                  </span>
                  <a-button size="large" type="primary"> Cập nhập </a-button>
                </div>
                <a-divider />
                <div class="flex items-center justify-between">
                  <span class="uppercase">
                    <i
                      class="fas fa-truck mr-2"
                      v-if="order?.delivery_status_code == DELYVERY_STATUS[0].value"
                    ></i>
                    <i class="fas fa-check mr-2 text-green-500" v-else></i>
                    {{ order?.delivery_status }}
                  </span>
                  <a-button size="large" type="primary"> Cập nhập </a-button>
                </div>

                <div class="mt-10">
                  <a-row :gutter="[16, 30]">
                    <a-col span="8">
                      <p class="text-[12px] font-bold text-gray-500">Mã đơn hàng</p>
                      <span class="text-[16px]"> {{ order?.code }}</span>
                    </a-col>
                    <a-col span="8">
                      <p class="text-[12px] font-bold text-gray-500">Trạng thái vận chuyện</p>
                      <a-tag :color="order?.delivery_status_color">{{
                        order?.delivery_status
                      }}</a-tag>
                    </a-col>
                    <a-col span="8">
                      <p class="text-[12px] font-bold text-gray-500">Hình thức thanh toán</p>
                      <span class="text-[16px]">
                        {{ order?.additional_details?.payment_method?.name }}</span
                      >
                    </a-col>
                    <a-col span="8">
                      <p class="text-[12px] font-bold text-gray-500">Cân nặng</p>
                      <span class="text-[16px]">{{ state.weight }} g</span>
                    </a-col>
                    <a-col span="8">
                      <p class="text-[12px] font-bold text-gray-500">Cập nhập lần cuối</p>
                      <span class="text-[16px]"> {{ order.delivered_at }}</span>
                    </a-col>
                    <a-col span="8" v-if="order?.payment_method_id == 1">
                      <p class="text-[12px] font-bold text-gray-500">Số tiền phải trả</p>
                      <span class="text-[16px]"> {{ formatCurrency(order?.final_price) }}</span>
                    </a-col>
                  </a-row>
                  <a-divider />

                  <a-button size="large"> Cập nhập trạng thái vận chuyển </a-button>
                </div>
              </a-card>
            </a-col>

            <a-col :span="7">
              <a-card class="mt-3" title="Khách hàng">
                <div class="mb-4">
                  <a-avatar :size="64">
                    <template #icon>
                      <img
                        src="https://martfury.botble.com/storage/customers/3-150x150.jpg"
                        alt="avatar"
                      />
                    </template>
                  </a-avatar>
                </div>
                <div class="flex flex-col gap-1">
                  <span class="font-bold">{{ order?.customer_name }}</span>
                  <a class="text-blue-500" :href="`mailto:${order?.customer_email}`">{{
                    order?.customer_email
                  }}</a>
                  <a class="text-blue-500" :href="`tel:${order?.customer_phone}`">{{
                    order?.customer_phone
                  }}</a>
                </div>
                <a-divider />

                <div>
                  <div class="flex items-center justify-between">
                    <h2 class="mb-1 text-[16px] text-[#222]">Địa chỉ giao hàng</h2>
                    <a-tooltip title="Thay đổi địa chỉ">
                      <i class="far fa-pen cursor-pointer"></i>
                    </a-tooltip>
                  </div>

                  <ul class="address">
                    <li>{{ order?.customer_name }}</li>
                    <li class="text-blue-500">
                      <i class="fas fa-phone mr-2"> </i>
                      <a class="text-blue-500" :href="`tel:${order?.customer_phone}`">{{
                        order?.customer_phone
                      }}</a>
                    </li>
                    <li>{{ order?.shipping_address }}</li>
                    <li>{{ order?.ward_name }}</li>
                    <li>{{ order?.district_name }}</li>
                    <li>{{ order?.province_name }}</li>
                    <li>
                      <a
                        class="text-blue-500"
                        :href="`https://maps.google.com/?q=${order?.shipping_address}`"
                        target="_blank"
                        >Xem địa chỉ trên bản đồ</a
                      >
                    </li>
                  </ul>
                </div>
              </a-card>
              <!-- Start Status -->
              <StatusView />
            </a-col>
          </a-row>
          <div class="p-20 text-center" v-else>
            <a-spin />
          </div>
        </form>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { MasterLayout, BreadcrumbComponent, AleartError } from '@/components/backend';
import StatusView from './partials/StatusView.vue';
import { computed, onMounted, reactive, ref } from 'vue';
import { useForm } from 'vee-validate';
import { formatCurrency, formatMessages } from '@/utils/format';
import { useStore } from 'vuex';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';
import { ORDER_STATUS, PAYMENT_STATUS, DELYVERY_STATUS } from '@/static/order';

// VARIABLES

const store = useStore();
const { getOne, update, messages, data } = useCRUD();
const code = computed(() => router.currentRoute.value.params.code || null);

// STATE
const state = reactive({
  endpoint: 'orders',
  pageTitle: 'Chi tiết đơn hàng',
  errors: {},
  weight: 0
});
const order = ref(null);

const { handleSubmit, setValues } = useForm({
  validationSchema: yup.object({
    name: yup.string().required('Tên thương hiệu không được để trống.')
  })
});

const onSubmit = handleSubmit(async (values) => {
  const response = await update(state.endpoint, code.value, values);
  if (!response) {
    return (state.errors = formatMessages(messages.value));
  }

  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  state.errors = {};
  router.push({ name: 'brand.index' });
});

const fetchOne = async () => {
  await getOne(state.endpoint, code.value);
  order.value = data.value;
  const { order_items, payment_status, delivery_status, order_status } = data.value;

  state.weight =
    order_items?.reduce((total, item) => {
      return total + (item.weight || 0) * (item.quantity || 0);
    }, 0) || 0;

  setValues({
    payment_status,
    delivery_status,
    order_status
  });
};

onMounted(() => {
  if (code.value) {
    fetchOne();
  }
});
</script>
<style scoped>
.address {
  margin-top: 7px;
  margin-bottom: 0;
}
.address li {
  margin-bottom: 5px;
}
</style>
