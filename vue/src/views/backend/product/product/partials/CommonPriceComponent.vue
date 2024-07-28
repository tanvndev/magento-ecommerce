<template>
  <a-row :gutter="[16, 16]">
    <a-col span="8">
      <InputNumberComponent name="import_price" label="Giá bán nhập" placeholder="Giá bán nhập" />
    </a-col>
    <a-col span="8">
      <InputNumberComponent name="price" label="Giá bán" placeholder="Giá bán" />
    </a-col>
    <a-col span="8">
      <InputNumberComponent name="sale_price" label="Giá bán ưu đãi" placeholder="Giá bán ưu đãi" />
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
  <a-row :gutter="[16, 16]" class="mt-4" v-if="isDiscountTime">
    <a-col span="24">
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
