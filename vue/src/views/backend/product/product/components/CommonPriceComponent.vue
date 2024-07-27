<template>
  <a-row :gutter="[20, 10]">
    <a-col span="12">
      <InputNumberComponent name="import_price" label="Giá bán nhập" />
    </a-col>
    <a-col span="12">
      <InputNumberComponent name="cog_price" label="Giá bán vốn" />
    </a-col>
    <a-col span="12">
      <InputNumberComponent name="price" label="Giá bán thường" />
    </a-col>
    <a-col span="12">
      <InputNumberComponent name="sale_price" label="Giá bán khuyến mãi" />
    </a-col>
    <a-col>
      <SwitchComponent
        name="is_discount_time"
        checkText="Lên lịch"
        uncheckText="Hủy lên lịch"
        @onChange="handleDiscountTime"
      />
    </a-col>
  </a-row>
  <a-row :gutter="[16, 10]" class="mt-3" v-if="isDiscountTime">
    <a-col span="12">
      <InputDateComponent type="date-range" name="sale_price_time" :showTime="true" />
    </a-col>
  </a-row>
</template>

<script setup>
import { InputNumberComponent, SwitchComponent, InputDateComponent } from '@/components/backend';
import { ref } from 'vue';

const isDiscountTime = ref(false);

const handleDiscountTime = (value) => {
  isDiscountTime.value = value;
};
</script>
