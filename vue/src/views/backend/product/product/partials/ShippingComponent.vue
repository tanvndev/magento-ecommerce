<template>
  <a-row :gutter="[16, 10]">
    <a-col span="6">
      <InputNumberComponent name="weight" label="Cân nặng (kg)" placeholder="Cân nặng" />
    </a-col>
    <a-col span="6">
      <InputNumberComponent name="length" label="Dài (cm)" placeholder="Dài" />
    </a-col>
    <a-col span="6">
      <InputNumberComponent name="width" label="Rộng (cm)" placeholder="Rộng" />
    </a-col>
    <a-col span="6">
      <InputNumberComponent name="hight" label="Cao (cm)" placeholder="Cao" />
    </a-col>
  </a-row>
  <a-row :gutter="[16, 10]" class="mt-4">
    <a-col span="24">
      <SelectComponent
        name="shipping_class"
        label="Lớp giao hàng"
        mode="multiple"
        placeholder="Chọn lớp giao hàng"
        :options="[]"
      />
    </a-col>
  </a-row>
</template>
<script setup>
import { InputNumberComponent, SelectComponent } from '@/components/backend';
</script>
