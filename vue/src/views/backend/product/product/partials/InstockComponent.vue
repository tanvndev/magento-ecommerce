<template>
  <h3 class="mb-5 text-center text-lg uppercase">Kiểm kê kho hàng</h3>
  <a-row :gutter="[30, 20]">
    <a-col span="12" v-for="warehouse in warehouses" :key="`${warehouse.id}_warehouse`">
      <h4 class="mb-2 text-center">{{ warehouse.name }}</h4>
      <a-row class="items-center" :gutter="[16, 20]">
        <a-col span="12">
          <InputNumberComponent :name="`in_stock[${warehouse.id}]`" placeholder="Tồn kho" />
        </a-col>
        <a-col span="12">
          <InputNumberComponent :name="`cog_price[${warehouse.id}]`" placeholder="Giá vốn" />
        </a-col>
      </a-row>
    </a-col>
  </a-row>
</template>
<script setup>
import { InputNumberComponent } from '@/components/backend';
import { onMounted, ref } from 'vue';
import { useCRUD } from '@/composables';

const warehouses = ref([]);

const { getAll } = useCRUD();

const getWarehouses = async () => {
  warehouses.value = await getAll('warehouses');
};

onMounted(getWarehouses);
</script>
