<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
    <TooltipComponent v-if="props.tooltipText" :title="props.tooltipText" />
  </label>
  <div>
    <!-- INPUT TEXT -->
    <a-input
      v-if="props.typeInput == 'text' && props.type != 'password'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :type="props.type"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :disabled="props.disabled"
    />

    <!-- INPUT PASSWORD -->
    <a-input-password
      v-if="props.typeInput == 'text' && props.type == 'password'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :type="props.type"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :disabled="props.disabled"
    />

    <!-- INPUT TEXTAREA -->
    <a-textarea
      v-if="props.typeInput == 'textarea'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :type="props.type"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :auto-size="{ minRows: 2, maxRows: 50 }"
      show-count
      :maxlength="props.maxlength"
      :disabled="props.disabled"
    />

    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>

<script setup>
import { useField } from 'vee-validate';
import { watch } from 'vue';
import { TooltipComponent } from '@/components/backend';

const props = defineProps({
  typeInput: {
    type: String,
    default: 'text'
  },
  required: {
    type: [Boolean, String],
    default: false
  },
  label: {
    type: String,
    default: ''
  },
  labelClass: {
    type: String,
    default: 'mb-2 block text-sm font-medium text-gray-900'
  },
  name: {
    type: String,
    required: true
  },
  className: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  placeholder: {
    type: String,
    default: ''
  },
  size: {
    type: String,
    default: 'large'
  },
  maxlength: {
    type: [String, Number, Boolean],
    default: 0
  },
  oldValue: {
    type: [String, Boolean, Number],
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

// Watch for changes in oldValue and set value accordingly
watch(
  () => props.oldValue,
  (newOldValue) => {
    if (newOldValue && newOldValue !== undefined && newOldValue !== value.value) {
      value.value = newOldValue;
    }
  },
  { immediate: true }
);
</script>
