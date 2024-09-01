<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
    <TooltipComponent v-if="props.tooltipText" :title="props.tooltipText" />
  </label>
  <div>
    <a-input-number
      v-if="props.typeInput == 'default'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :placeholder="props.placeholder"
      :status="errorMessage || props.activeError ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :formatter="formatNumber"
      :parser="parseNumber"
      @change="handleChange"
    />

    <a-input-number
      v-if="props.typeInput == 'percent'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :placeholder="props.placeholder"
      :status="errorMessage || props.activeError ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :min="props.min"
      :max="props.max"
      :formatter="(value) => `${value}%`"
      :parser="(value) => value.replace('%', '')"
      @change="handleChange"
    />

    <span
      v-if="errorMessage || props.activeError"
      class="mt-[6px] block text-[12px] text-red-500"
      >{{ errorMessage || props.activeError }}</span
    >
  </div>
</template>

<script setup>
import { TooltipComponent } from '@/components/backend';
import { debounce } from '@/utils/helpers';
import { useField } from 'vee-validate';
import { watch } from 'vue';

const emits = defineEmits(['onChange']);

const props = defineProps({
  typeInput: {
    type: String,
    default: 'default'
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
    default: 'w-full'
  },

  placeholder: {
    type: String,
    default: ''
  },
  size: {
    type: String,
    default: 'large'
  },
  min: {
    type: Number,
    default: 0
  },
  max: {
    type: Number,
    default: 100
  },
  tooltipText: {
    type: String,
    default: ''
  },
  oldValue: {
    type: [String, Boolean, Number],
    default: ''
  },
  activeError: {
    type: [Boolean, String],
    default: false
  }
});

const debouncedHandleChange = debounce((value) => {
  emits('onChange', value);
}, 300);

const handleChange = (value) => {
  debouncedHandleChange(value);
};

const formatNumber = (value) => {
  if (!value) return '';
  // Convert to string, then add thousands separators using dot.
  return `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
};

const parseNumber = (value) => {
  // Remove all non-numeric characters (including dots) and convert to number.
  return value.replace(/\./g, '').replace(/[^0-9]/g, '');
};

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);

// Watch for changes in oldValue and set value accordingly
watch(
  () => props.oldValue,
  (newOldValue) => {
    if (newOldValue && newOldValue !== undefined && newOldValue !== value.value) {
      value.value = newOldValue;
      handleChange(newOldValue);
    }
  },
  { immediate: true }
);
</script>
