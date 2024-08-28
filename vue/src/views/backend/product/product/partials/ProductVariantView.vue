<template>
  <form>
    <a-col span="24" class="mt-3">
      <a-row :gutter="[16, 16]">
        <!-- Attribute -->
        <a-col span="7">
          <a-card>
            <template #title>
              <div class="flex items-center justify-between">
                <span> Phiên bản </span>
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
                <div class="rounded border">
                  <img class="w-[50px] object-cover" :src="variant.image" alt="Chưa có ảnh" />
                </div>
                <div>
                  <p class="mb-1 text-[16px] text-primary-500">{{ variant.attribute_values }}</p>
                  <span class="text-[16px] text-gray-500"
                    >Tồn kho: <a-tag :color="variant.stock_color">{{ variant.stock }}</a-tag>
                  </span>
                </div>
              </li>
            </ul>
          </a-card>
        </a-col>
        <!-- Main -->
        <a-col span="17">
          <a-card>
            <template #title>
              <div class="flex items-center justify-between">
                <div>
                  Thông tin phiên bản
                  <TooltipComponent title="Bạn lưu ý nhấn 'Cập nhập phiên bản' để cập nhập." />
                </div>
                <a-button type="dashed">Cập nhập phiên bản</a-button>
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
                <div class="mb-3">
                  <label class="mb-2 block text-sm font-medium text-gray-900">Mau sac</label>
                  <div class="flex h-[40px] w-full items-center rounded-[10px] border px-3">
                    Xanh
                  </div>
                </div>
                <div class="mb-3">
                  <label class="mb-2 block text-sm font-medium text-gray-900">Mau sac</label>
                  <div class="flex h-[40px] w-full items-center rounded-[10px] border px-3">
                    Xanh
                  </div>
                </div>
                <div class="mb-3">
                  <label class="mb-2 block text-sm font-medium text-gray-900">Mau sac</label>
                  <div class="flex h-[40px] w-full items-center rounded-[10px] border px-3">
                    Xanh
                  </div>
                </div>
              </a-col>
              <a-col span="12" class="flex items-center justify-center">
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
import { reactive, watchEffect } from 'vue';
import { useRoute, useRouter } from 'vue-router';

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
  activeVariantSelectedId: null
});

watchEffect(() => {
  state.activeVariantSelectedId = route.query.variant_id ? route.query.variant_id : null;
});

const handleDiscountTime = (value) => {
  state.isDiscountTime = value;
};
const handleSelectVariant = (variant) => {
  router.push({
    path: router.currentRoute.value.path,
    query: {
      ...router.currentRoute.value.query,
      variant_id: variant.id
    }
  });
};
</script>
<style scoped>
.list-variant {
  height: 1094px;
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
