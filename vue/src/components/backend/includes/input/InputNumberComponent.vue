<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span></label
  >
  <div>
    <a-input-number
      v-if="props.typeInput == 'default'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :formatter="(value) => `${value}`.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
      :parser="(value) => value.replace(/\\s?|(,*)/g, '')"
    />

    <a-input-number
      v-if="props.typeInput == 'percent'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :min="props.min"
      :max="props.max"
      :formatter="(value) => `${value}%`"
      :parser="(value) => value.replace('%', '')"
    />

    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>

<script setup>
import { useField } from 'vee-validate';

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
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>
