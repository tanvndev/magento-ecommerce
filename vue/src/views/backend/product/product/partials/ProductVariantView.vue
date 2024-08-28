<template>
  <form @submit.prevent="onSubmit">
    <a-col span="24" class="mt-3">
      <a-row :gutter="[16, 16]">
        <!-- Attribute -->
        <a-col span="8">
          <a-card>
            <template #title>
              <div class="flex items-center justify-between">
                <div>
                  <span> Phiên bản ({{ props.variants.length }})</span>
                  <TooltipComponent
                    title="Bạn lưu ý nếu sản phẩm bị khóa thì sẽ không được phép sửa và xóa."
                  />
                </div>
                <a-button type="dashed">Sửa thuộc tính</a-button>
              </div>
            </template>
            <ul class="list-variant">
              <li
                class="item-variant flex items-center gap-4"
                v-for="variant in props.variants"
                :key="variant.id"
                :class="{ active: state.activeVariantSelectedId == variant.id }"
                @click="handleSelectVariant(variant)"
              >
                <div class="flex items-center">
                  <a-tag :color="variant.lock_color">
                    <i :class="variant.lock_icon"></i>
                  </a-tag>
                  <div class="rounded border">
                    <img class="w-[50px] object-cover" :src="variant.image" alt="Chưa có ảnh" />
                  </div>
                </div>
                <div>
                  <p class="mb-1 text-[16px] text-primary-500">{{ variant.attribute_values }}</p>
                  <span class="text-[16px] text-gray-500"
                    >Tồn kho: <a-tag :color="variant.stock_color">{{ variant.stock }}</a-tag>
                  </span>
                </div>
                <div class="ml-auto">
                  <a-popconfirm
                    :title="`Bạn có chắc chắn muốn xóa phiên bản |${variant.attribute_values}|? Thao tác này không thể khôi phục.`"
                    ok-text="Xóa"
                    cancel-text="Hủy"
                    @confirm="handleRemoveVariant(variant.id)"
                  >
                    <a-button class="text-gray-600 hover:text-red-500" type="danger">
                      <i class="fas fa-trash-alt text-[16px]"></i>
                    </a-button>
                  </a-popconfirm>
                </div>
              </li>
            </ul>
          </a-card>
        </a-col>
        <!-- Main -->
        <a-col span="16">
          <a-card>
            <template #title>
              <div class="flex items-center justify-between">
                <div>
                  Thông tin phiên bản
                  <TooltipComponent title="Bạn lưu ý nhấn 'Cập nhập phiên bản' để cập nhập." />
                </div>
                <a-space>
                  <a-button html-type="submit" type="dashed">Cập nhập phiên bản</a-button>
                </a-space>
              </div>
            </template>
            <a-row :gutter="[16, 16]">
              <a-col span="24">
                <InputComponent
                  name="variable[name]"
                  label="Tên phiên bản"
                  placeholder="Tên phiên bản"
                />
              </a-col>
              <a-col span="24">
                <InputComponent name="variable[sku]" label="SKU" placeholder="SKU" />
              </a-col>
              <a-col span="6">
                <InputNumberComponent
                  name="variable[weight]"
                  label="Cân nặng (kg)"
                  placeholder="Cân nặng"
                />
              </a-col>
              <a-col span="6">
                <InputNumberComponent name="variable[length]" label="Dài (cm)" placeholder="Dài" />
              </a-col>
              <a-col span="6">
                <InputNumberComponent name="variable[width]" label="Rộng (cm)" placeholder="Rộng" />
              </a-col>
              <a-col span="6">
                <InputNumberComponent name="variable[height]" label="Cao (cm)" placeholder="Cao" />
              </a-col>
              <a-col span="12">
                <InputNumberComponent
                  name="variable[stock]"
                  label="Số lượng"
                  placeholder="Số lượng"
                />
              </a-col>
              <a-col span="12">
                <InputNumberComponent
                  name="variable[low_stock_amount]"
                  label="Ngưỡng sắp hết hàng"
                  placeholder="Ngưỡng sắp hết hàng"
                />
              </a-col>
            </a-row>
          </a-card>

          <a-card title="Thuộc tính" class="mt-3">
            <a-row :gutter="[16, 16]">
              <a-col span="12">
                <div v-for="attribute in state.attributes" :key="attribute.id" class="mb-3">
                  <label class="mb-2 block text-sm font-medium text-gray-900">
                    {{ attribute.attribute_name }}
                  </label>
                  <div class="flex h-[40px] w-full items-center rounded-[10px] border px-3">
                    {{ attribute.name }}
                  </div>
                </div>
              </a-col>
              <a-col span="12" class="flex flex-col items-center justify-center">
                <h2 class="-ml-[10px] text-sm">Ảnh</h2>
                <InputFinderComponent name="variable[image]" />
              </a-col>
            </a-row>
          </a-card>

          <a-card title="Giá bán" class="mt-3">
            <a-row :gutter="[16, 16]">
              <a-col span="8">
                <InputNumberComponent
                  name="variable[cost_price]"
                  label="Giá bán nhập"
                  placeholder="Giá bán nhập"
                />
              </a-col>
              <a-col span="8">
                <InputNumberComponent
                  name="variable[price]"
                  label="Giá bán"
                  placeholder="Giá bán"
                />
              </a-col>
              <a-col span="8">
                <InputNumberComponent
                  name="variable[sale_price]"
                  label="Giá bán ưu đãi"
                  placeholder="Giá bán ưu đãi"
                />
              </a-col>
              <a-col>
                <SwitchComponent
                  name="variable[is_discount_time]"
                  checkText="Lên lịch"
                  uncheckText="Hủy lên lịch"
                  @onChange="handleDiscountTime"
                />
              </a-col>
            </a-row>
            <a-row :gutter="[16, 16]" class="mt-4" v-if="state.isDiscountTime">
              <a-col span="24">
                <InputDateComponent
                  type="date-range"
                  name="variable[sale_price_time]"
                  :showTime="true"
                />
              </a-col>
            </a-row>
          </a-card>

          <!-- Album -->
          <a-card class="mt-3" title="Thư viện sản phẩm">
            <InputFinderComponent :multipleFile="true" name="variable[album]" />
          </a-card>
        </a-col>
      </a-row>
    </a-col>
  </form>
</template>
<script setup>
import {
  InputComponent,
  InputNumberComponent,
  InputDateComponent,
  InputFinderComponent,
  SwitchComponent,
  TooltipComponent
} from '@/components/backend';
import { useCRUD } from '@/composables';
import { reactive, watchEffect, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const { getOne, getAll, update, messages, data } = useCRUD();
import { useForm } from 'vee-validate';
import validationVariantSchema from '../validationVariantSchema';
import { useStore } from 'vuex';
import { formatMessages } from '@/utils/format';
import _ from 'lodash';
import { handleDateChangeToAnt } from '@/utils/helpers';

const store = useStore();
const route = useRoute();
const router = useRouter();

const props = defineProps({
  variants: {
    type: Array,
    default: () => []
  }
});

const state = reactive({
  isDiscountTime: false,
  activeVariantSelectedId: null,
  attributes: []
});

const { handleSubmit, setValues, errors } = useForm({
  validationVariantSchema
});

// Function to fetch variant data and update form values
const fetchAndSetVariant = async (variantId) => {
  const variant = props.variants.find((v) => v.id == variantId);
  if (_.isEmpty(variant)) {
    return;
  }
  if (variant) {
    setValues({
      'variable[name]': variant?.name || '',
      'variable[sku]': variant?.sku || '',
      'variable[weight]': variant?.weight || '',
      'variable[length]': variant?.length || '',
      'variable[width]': variant?.width || '',
      'variable[height]': variant?.height || '',
      'variable[stock]': variant?.stock || '',
      'variable[low_stock_amount]': variant?.low_stock_amount || '',
      'variable[cost_price]': variant?.cost_price || '',
      'variable[price]': variant?.price || '',
      'variable[sale_price]': variant?.sale_price || '',
      'variable[image]': variant?.image || '',
      'variable[album]': variant?.album || [],
      'variable[is_discount_time]': variant?.is_discount_time,
      'variable[sale_price_time]': handleDateChangeToAnt(variant?.sale_price_time)
    });
    state.attributes = variant?.attributes || [];
    state.activeVariantSelectedId = variantId;
    state.isDiscountTime = variant?.is_discount_time
  }
};

const onSubmit = handleSubmit(async (values) => {
  console.log(values);

  state.error = {};
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  store.commit('productStore/removeAll');
  // router.push({ name: 'product.index' });
});

const handleDiscountTime = (value) => {
  setValues({
    'variable[is_discount_time]': value
  });

  state.isDiscountTime = value;
};

const handleSelectVariant = (variant) => {
  router.push({
    path: router.currentRoute.value.path,
    query: { ...router.currentRoute.value.query, variant_id: variant.id }
  });
};

const handleRemoveVariant = () => {
  //   router.push({ path: router.currentRoute.value.path, query: {} });
};

watchEffect(() => {
  const variantId = route.query.variant_id;
  if (route.query.variant_id && variantId != state.activeVariantSelectedId) {
    fetchAndSetVariant(variantId);
  }
});
</script>
<style scoped>
.list-variant {
  height: 1103px;
  overflow-y: auto;
}
.item-variant {
  padding: 8px;
  border-radius: 8px;
  margin-bottom: 10px;
  cursor: pointer;
}
.item-variant:last-child {
  margin-bottom: 0;
}
.item-variant:hover {
  background-color: rgb(242, 249, 255);
}
.item-variant.active {
  background-color: rgb(242, 249, 255);
}
</style>
