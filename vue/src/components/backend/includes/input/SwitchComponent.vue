<template>
  <a-switch v-model:checked="value" :size="props.size" @change="handleChange">
    <template #checkedChildren>
      {{ props.checkText }}
    </template>
    <template #unCheckedChildren>
      {{ props.uncheckText }}
    </template>
  </a-switch>
</template>

<script setup>
const emits = defineEmits(['onChange']);
const handleChange = (value) => {
  emits('onChange', value);
};

import { useField } from 'vee-validate';

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  size: {
    type: String,
    default: 'default'
  },
  checkText: {
    type: String,
    default: ''
  },
  uncheckText: {
    type: String,
    default: ''
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>
