<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span></label
  >
  <div>
    <!-- INPUT HIDDEN -->
    <input
      v-if="props.typeInput == 'hidden'"
      type="hidden"
      :name="props.name"
      :v-model:value="value"
      :value="props.defaultValue"
    />

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
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>
