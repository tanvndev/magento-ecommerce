<script setup>
import { useRouter, useRoute } from 'vue-router';
import BaseService from '@/services/BaseService';
import { message } from 'ant-design-vue';

const emits = defineEmits(['onChangeToolbox']);

const router = useRouter();
const route = useRoute();
const props = defineProps({
  titlePage: {
    type: String,
    required: true
  },
  isShowToolbox: {
    type: Boolean
  },
  routeCreate: {
    type: String,
    required: true
  },
  modelName: {
    type: String,
    required: true
  },
  modelIds: {
    type: [Object, Array]
  }
});

const handleChangePublish = async (value) => {
  const payload = {
    modelName: props.modelName,
    modelIds: props.modelIds,
    field: 'publish',
    value
  };

  const response = await BaseService.changeStatusAll(payload);
  const type = response.success ? 'success' : 'error';

  emits('onChangeToolbox');
  message[type](response.messages);
};

const removeRouteHide = () => {
  const routeHide = ['permission.index', 'attribute.index', 'order.index'];
  if (routeHide.includes(route.name)) {
    return false;
  }
  return true;
};
</script>
<template>
  <a-card class="mb-2 mt-4">
    <a-page-header class="p-0" @back="() => router.back()">
      <template #title>
        <span class="text-[18px] uppercase">
          {{ titlePage }}
        </span>
      </template>

      <template #extra>
        <a-button
          v-if="route.name == 'user.catalogue.index'"
          size="large"
          class="btn-warning"
          @click="() => router.push({ name: 'user.catalogue.permission' })"
        >
          <i class="fas fa-key-skeleton mr-2 text-[13px]"></i>
          <span>Phân Quyền</span>
        </a-button>

        <a-button
          size="large"
          type="primary"
          class="btn-success"
          @click="() => router.push({ name: routeCreate })"
        >
          <i class="far fa-plus mr-2 text-[14px]"></i>
          Thêm mới
        </a-button>
      </template>
    </a-page-header>
  </a-card>
</template>
