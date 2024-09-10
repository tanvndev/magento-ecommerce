<template>
  <form @submit.prevent="onSubmit">
    <a-row :gutter="[16, 16]">
      <!-- Attribute -->
      <a-col span="8">
        <a-card>
          <template #title>
            <div class="flex items-center justify-between">
              <div>
                <span> Phiên bản ({{ props.variants.length }})</span>
                <TooltipComponent
                  title="Bạn lưu ý nếu sản phẩm bị khóa thì có nghĩa là sản phẩm đã được có trong đơn hàng sẽ không được phép và xóa."
                />
              </div>
              <div v-if="props.productType == 'variable'">
                <ProductVariantAttributeVariableView
                  :attribute-enable-ids="props.attributeEnableIds"
                  :attribute-enable-old="props.attributeEnableOld"
                  :attribute-data="props.attributeData"
                  @on-reload="() => emits('onReload')"
                  v-if="productTypeOld == 'variable'"
                />
                <ProductVariantAttributeSimpleView
                  :attribute-data="props.attributeData"
                  @on-reload="() => emits('onReload')"
                  v-if="productTypeOld == 'simple'"
                />
              </div>
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
                  <img
                    class="w-[50px] object-cover"
                    :src="resizeImage(variant.image, 100)"
                    alt="Chưa có ảnh"
                  />
                </div>
              </div>
              <div>
                <p class="mb-1 text-[16px] text-primary-500">
                  {{ variant.attribute_values || 'Mặc định' }}
                </p>
                <span class="text-[16px] text-gray-500"
                  >Tồn kho: <a-tag :color="variant.stock_color">{{ variant.stock }}</a-tag>
                </span>
              </div>
              <div class="ml-auto" v-if="props.variants.length > 1 && variant.is_used == false">
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
          <AleartError :errors="state.error" />
          <a-row :gutter="[16, 16]">
            <div class="hidden">
              <!-- variant_id -->
              <InputComponent name="variable_id" />
              <SwitchComponent name="variable_is_used" />
            </div>
            <a-col span="24">
              <InputComponent
                name="variable_name"
                label="Tên phiên bản"
                placeholder="Tên phiên bản"
              />
            </a-col>
            <a-col span="24">
              <InputComponent name="variable_sku" label="SKU" placeholder="SKU" />
            </a-col>
            <a-col span="6">
              <InputNumberComponent
                name="variable_weight"
                label="Cân nặng (kg)"
                placeholder="Cân nặng"
              />
            </a-col>
            <a-col span="6">
              <InputNumberComponent name="variable_length" label="Dài (cm)" placeholder="Dài" />
            </a-col>
            <a-col span="6">
              <InputNumberComponent name="variable_width" label="Rộng (cm)" placeholder="Rộng" />
            </a-col>
            <a-col span="6">
              <InputNumberComponent name="variable_height" label="Cao (cm)" placeholder="Cao" />
            </a-col>
            <a-col span="12">
              <InputNumberComponent name="variable_stock" label="Số lượng" placeholder="Số lượng" />
            </a-col>
            <a-col span="12">
              <InputNumberComponent
                name="variable_low_stock_amount"
                label="Ngưỡng sắp hết hàng"
                placeholder="Ngưỡng sắp hết hàng"
              />
            </a-col>
          </a-row>
        </a-card>

        <a-card title="Thuộc tính" class="mt-3">
          <a-row :gutter="[16, 16]">
            <a-col span="12" v-if="state.attributes.length > 0">
              <div v-for="attribute in state.attributes" :key="attribute.id" class="mb-3">
                <label class="mb-2 block text-sm font-medium text-gray-900">
                  {{ attribute.attribute_name }}
                </label>
                <div class="flex h-[40px] w-full items-center rounded-[10px] border px-3">
                  {{ attribute.name }}
                </div>
              </div>
            </a-col>
            <a-col span="12" v-else>
              <a-empty :image="Empty.PRESENTED_IMAGE_SIMPLE" />
            </a-col>
            <a-col span="12" class="flex flex-col items-center justify-center">
              <h2 class="-ml-[10px] text-sm">Ảnh</h2>
              <InputFinderComponent name="variable_image" />
            </a-col>
          </a-row>
        </a-card>

        <a-card title="Giá bán" class="mt-3">
          <a-row :gutter="[16, 16]">
            <a-col span="8">
              <InputNumberComponent
                name="variable_cost_price"
                label="Giá bán nhập"
                placeholder="Giá bán nhập"
              />
            </a-col>
            <a-col span="8">
              <InputNumberComponent name="variable_price" label="Giá bán" placeholder="Giá bán" />
            </a-col>
            <a-col span="8">
              <InputNumberComponent
                name="variable_sale_price"
                label="Giá bán ưu đãi"
                placeholder="Giá bán ưu đãi"
              />
            </a-col>
            <a-col>
              <SwitchComponent
                name="variable_is_discount_time"
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
                name="variable_sale_price_time"
                :showTime="true"
              />
            </a-col>
          </a-row>
        </a-card>

        <!-- Album -->
        <a-card class="mt-3" title="Thư viện sản phẩm">
          <InputFinderComponent :multipleFile="true" name="variable_album" />
        </a-card>
      </a-col>
    </a-row>
  </form>
</template>
<script setup>
import {
  InputComponent,
  InputNumberComponent,
  InputDateComponent,
  InputFinderComponent,
  SwitchComponent,
  TooltipComponent,
  AleartError
} from '@/components/backend';
import { useCRUD } from '@/composables';
import { computed, reactive, watchEffect } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const { update, deleteOne, messages } = useCRUD();
import { useForm } from 'vee-validate';
import { validationVariantSchema } from '../validationSchema';
import { useStore } from 'vuex';
import { formatMessages } from '@/utils/format';
import _ from 'lodash';
import { handleDateChangeToAnt, resizeImage } from '@/utils/helpers';
import { message } from 'ant-design-vue';
import { Empty } from 'ant-design-vue';
import ProductVariantAttributeVariableView from './ProductVariantAttributeVariableView.vue';
import ProductVariantAttributeSimpleView from './ProductVariantAttributeSimpleView.vue';

const store = useStore();
const route = useRoute();
const router = useRouter();

const emits = defineEmits(['onReload']);
const props = defineProps({
  variants: {
    type: Array,
    default: () => []
  },
  productType: {
    type: String,
    default: ''
  },
  attributeEnableOld: {
    type: Array,
    default: () => []
  },
  attributeEnableIds: {
    type: Array,
    default: () => []
  },
  attributeData: {
    type: Array,
    default: () => []
  }
});

const productTypeOld = computed(() => store.getters['productStore/getProductType']);
const state = reactive({
  isDiscountTime: false,
  activeVariantSelectedId: null,
  attributes: [],
  error: {},
  endpoint: 'products/variants'
});

const { handleSubmit, setValues } = useForm({
  validationSchema: validationVariantSchema
});

// Function to fetch variant data and update form values
const fetchAndSetVariant = async (variantId) => {
  const variant = props.variants.find((v) => v.id == variantId);
  if (_.isEmpty(variant)) {
    return;
  }
  if (variant) {
    setValues({
      variable_id: variant?.id || 0,
      variable_name: variant?.name || '',
      variable_sku: variant?.sku || '',
      variable_weight: variant?.weight || null,
      variable_length: variant?.length || null,
      variable_width: variant?.width || null,
      variable_height: variant?.height || null,
      variable_stock: variant?.stock || null,
      variable_low_stock_amount: variant?.low_stock_amount || null,
      variable_cost_price: variant?.cost_price || null,
      variable_price: variant?.price || null,
      variable_sale_price: variant?.sale_price || null,
      variable_image: variant?.image || '',
      variable_album: variant?.album || [],
      variable_is_discount_time: variant?.is_discount_time,
      variable_sale_price_time: handleDateChangeToAnt(variant?.sale_price_time),
      variable_is_used: variant?.is_used
    });
    state.attributes = variant?.attributes || [];
    state.activeVariantSelectedId = variantId;
    state.isDiscountTime = variant?.is_discount_time;
  }
};

const onSubmit = handleSubmit(async (values) => {
  const endpoint = state.endpoint + '/update';
  const response = await update(endpoint, null, values);

  if (!response) {
    return (state.error = formatMessages(messages.value));
  }

  state.error = {};
  message.success(messages.value);
  store.commit('productStore/removeAll');
  emits('onReload');
});

const handleDiscountTime = (value) => {
  setValues({
    variable_is_discount_time: value
  });

  state.isDiscountTime = value;
};

const handleSelectVariant = (variant) => {
  router.push({
    path: router.currentRoute.value.path,
    query: { ...router.currentRoute.value.query, variant_id: variant.id }
  });
};

const handleRemoveVariant = async (variantId) => {
  if (props.variants.length <= 1) {
    message.warning('Phải giữ lại ít nhất một phiên bản.');
    return;
  }

  const endpoint = `${state.endpoint}/delete`;
  const response = await deleteOne(endpoint, variantId);

  if (!response) {
    message.error(messages.value);
    return;
  }

  message.success(messages.value);
  const remainingVariants = props.variants.filter((v) => v.id !== variantId);
  if (remainingVariants.length > 0) {
    const newQuery = { ...router.currentRoute.value.query, variant_id: remainingVariants[0].id };
    if (router.currentRoute.value.query.variant_id !== remainingVariants[0].id) {
      router.push({ path: router.currentRoute.value.path, query: newQuery });
    }
  }
  emits('onReload');
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
