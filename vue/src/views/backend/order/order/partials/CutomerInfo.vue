<template>
  <a-card class="mt-3" title="Khách hàng">
    <div class="mb-4">
      <a-avatar :size="55">
        <template #icon>
          <img :src="order?.user?.image" :alt="order?.customer_name" />
        </template>
      </a-avatar>
    </div>
    <div class="flex flex-col gap-1">
      <span class="font-bold">{{ order?.customer_name }}</span>
      <a class="text-blue-500" :href="`mailto:${order?.customer_email}`">{{
        order?.customer_email
      }}</a>
      <a class="text-blue-500" :href="`tel:${order?.customer_phone}`">{{
        order?.customer_phone
      }}</a>
    </div>
    <a-divider />

    <div>
      <div class="flex items-center justify-between">
        <h2 class="mb-1 text-[16px] text-[#222]">Địa chỉ giao hàng</h2>
        <a-tooltip title="Thay đổi địa chỉ">
          <i class="far fa-pen cursor-pointer"></i>
        </a-tooltip>
      </div>

      <ul class="address">
        <li>{{ order?.customer_name }}</li>
        <li class="text-blue-500">
          <i class="fas fa-phone mr-2"> </i>
          <a class="text-blue-500" :href="`tel:${order?.customer_phone}`">{{
            order?.customer_phone
          }}</a>
        </li>
        <li>{{ order?.shipping_address }}</li>
        <li>{{ order?.ward_name }}</li>
        <li>{{ order?.district_name }}</li>
        <li>{{ order?.province_name }}</li>
        <li>
          <a
            class="text-blue-500"
            :href="`https://maps.google.com/?q=${order?.shipping_address}`"
            target="_blank"
            >Xem địa chỉ trên bản đồ</a
          >
        </li>
      </ul>
    </div>
  </a-card>
</template>
<script setup>
defineProps({
  order: Object
});
</script>

<style scoped>
.address {
  margin-top: 7px;
  margin-bottom: 0;
}
.address li {
  margin-bottom: 5px;
}
</style>
