<template>
  <div class="text-center">
    <label class="switch">
      <input
        type="checkbox"
        @change="handleChangePublish($event)"
        :checked="props.record?.publish == 1 ? true : false"
      />
      <span class="slider"></span>
    </label>
  </div>
</template>

<script setup>
import BaseService from '@/services/BaseService';
import { message } from 'ant-design-vue';

const props = defineProps({
  record: Object,
  field: String,
  modelName: String
});

const handleChangePublish = async (event) => {
  const payload = {
    modelName: props.modelName,
    modelId: props.record?.id,
    field: props.field,
    value: event.target.checked ? 1 : 2
  };
  const response = await BaseService.changeStatus(payload);
  const type = response.success ? 'success' : 'error';

  message[type](response.messages);
};
</script>
