<template>
  <a-typography-title :level="4">Cấu hình chung</a-typography-title>

  <a-card class="mt-3" title="Thông tin cửa hàng">
    <a-row :gutter="[16, 16]">
      <a-col span="12">
        <InputComponent name="name" label="Tên cửa hàng" placeholder="Nhập tên cửa hàng" />
      </a-col>
    </a-row>
  </a-card>
</template>

<script setup>
import { InputComponent } from '@/components/backend';
</script>
