<template>
  <a-row :gutter="[16, 16]">
    <a-col span="12" v-if="props.productType === 'simple'">
      <InputNumberComponent name="stock" label="Số lượng" placeholder="Nhập số lượng" />
    </a-col>
    <a-col span="12" v-if="props.productType === 'simple'">
      <InputNumberComponent name="low_stock_amount" label="Ngưỡng sắp hết hàng" placeholder="Nhập số lượng" tooltip-text="Khi lượng hàng tồn kho đạt đến số lượng này, bạn sẽ được thông báo qua email. Có thể xác định các giá trị khác nhau cho từng biến thể riêng lẻ." />
    </a-col>
    <a-col span="8">
      <InputNumberComponent
        name="cost_price"
        label="Giá bán nhập"
        placeholder="Giá bán nhập"
        @onChange="handleCostPrice"
      />
    </a-col>
    <a-col span="8">
      <InputNumberComponent
        name="price"
        label="Giá bán"
        placeholder="Giá bán"
        @onChange="handlePrice"
      />
    </a-col>
    <a-col span="8">
      <InputNumberComponent name="sale_price" label="Giá bán ưu đãi" placeholder="Giá bán ưu đãi" />
    </a-col>
    <a-col v-if="props.productType === 'simple'" span="24">
      <SwitchComponent
        name="is_discount_time"
        checkText="Lên lịch"
        uncheckText="Hủy lên lịch"
        @onChange="handleDiscountTime"
      />
    </a-col>
  </a-row>
  <a-row :gutter="[16, 16]" class="mt-4" v-if="isDiscountTime">
    <a-col span="24">
      <InputDateComponent type="date-range" name="sale_price_time" :showTime="true" />
    </a-col>
  </a-row>
</template>

<script setup>
import { InputNumberComponent, SwitchComponent, InputDateComponent } from '@/components/backend';
import { ref } from 'vue';
import { useStore } from 'vuex';
const store = useStore();

const props = defineProps({
  productType: {
    type: String,
    default: ''
  }
});

const isDiscountTime = ref(false);

const handleCostPrice = (value) => {
  store.commit('productStore/setCostPrice', value);
};

const handlePrice = (value) => {
  store.commit('productStore/setPrice', value);
};

const handleDiscountTime = (value) => {
  isDiscountTime.value = value;
};
</script>
