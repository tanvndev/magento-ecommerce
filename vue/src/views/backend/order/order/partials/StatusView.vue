<template>
  <a-card class="mt-3" title="Trạng thái">
    <a-row :gutter="[16, 16]">
      <a-col span="24">
        <SelectComponent name="order_status" label="Trạng thái đơn hàng" :options="ORDER_STATUS" />
      </a-col>
      <a-col span="24">
        <SelectComponent name="payment_status" label="Trạng thái thanh toán" :options="PAYMENT_STATUS" />
      </a-col>
      <a-col span="24">
        <SelectComponent name="delivery_status" label="Trạng thái vận chuyển" :options="DELYVERY_STATUS" />
      </a-col>
      <a-col span="24">
        <a-button class="float-end" size="large"> Cập nhập </a-button>
      </a-col>
    </a-row>
  </a-card>
</template>
<script setup>
import { AleartError, SelectComponent } from '@/components/backend';
import { ORDER_STATUS, PAYMENT_STATUS, DELYVERY_STATUS } from '@/static/order';

</script>
