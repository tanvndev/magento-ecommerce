<template>
  <a-typography-title :level="4">Phương thức thanh toán</a-typography-title>

  <a-card class="mt-3" title="Thông tin cửa hàng">
    <a-row :gutter="[16, 16]">
      <a-col>
        <InputComponent name="name" label="Tên cửa hàng" />
      </a-col>
    </a-row>
  </a-card>
</template>
<script setup>
import { InputComponent } from '@/components/backend';
</script>
