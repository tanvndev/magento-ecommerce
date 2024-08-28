<template>
  <div class="flex items-center">
    <a-switch
      v-model:checked="value"
      :size="props.size"
      @change="handleChange"
      :disabled="props.disabled"
    >
      <template #checkedChildren>
        {{ props.checkText }}
      </template>
      <template #unCheckedChildren>
        {{ props.uncheckText }}
      </template>
    </a-switch>
    <TooltipComponent v-if="props.tooltipText" :title="props.tooltipText" />
  </div>
</template>

<script setup>
import TooltipComponent from '../TooltipComponent.vue';
const emits = defineEmits(['onChange']);
const handleChange = (value) => {
  emits('onChange', value ?? false);
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
  },
  tooltipText: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>
