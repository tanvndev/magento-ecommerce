<template>
  <a-row :gutter="[16, 16]" class="mb-5 mt-2">
    <a-col span="6">
      <label class="font-bold">CHI NHÁNH </label>
    </a-col>
    <a-col span="9">
      <label class="font-bold">TỒN KHO BAN ĐẦU</label>
    </a-col>
    <a-col span="9">
      <label class="font-bold">GIÁ VỐN</label>
    </a-col>
  </a-row>
  <a-row
    class="mb-4 items-center"
    :gutter="[20, 20]"
    v-for="warehouse in props.warehouses"
    :key="`${warehouse.id}_warehouse`"
  >
    <a-col span="6">
      <label class="uppercase">
        <i class="far fa-dolly-flatbed-alt mr-2"></i>
        {{ warehouse.name }}
      </label>
    </a-col>
    <a-col span="9">
      <InputNumberComponent :name="`stock[in_stock][${warehouse.id}][]`" placeholder="Tồn kho" />
    </a-col>
    <a-col span="9">
      <InputNumberComponent :name="`stock[cog_price][${warehouse.id}][]`" placeholder="Giá vốn" />
    </a-col>
  </a-row>
</template>
<script setup>
import { InputNumberComponent } from '@/components/backend';

const props = defineProps({
  warehouses: {
    type: [Array, Object],
    default: () => []
  }
});
</script>
