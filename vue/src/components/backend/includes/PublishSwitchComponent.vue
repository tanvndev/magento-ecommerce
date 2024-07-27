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
import { useStore } from 'vuex';

const store = useStore();
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

  store.dispatch('antStore/showMessage', { type, message: response.messages });
};
</script>
