<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span></label
  >
  <div>
    <a-date-picker
      v-if="props.type === 'date'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :show-time="props.showTime"
      :placeholder="props.placeholder"
      @change="handleChange"
    />
    <a-range-picker
      v-if="props.type === 'date-range'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :show-time="props.showTime"
      :placeholder="props.rangePlaceholder"
      @change="handleChange"
    />
    <a-time-picker
      v-if="props.type === 'time'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :show-time="props.showTime"
      :placeholder="props.rangePlaceholder"
      @change="handleChange"
    />
    <a-time-range-picker
      v-if="props.type === 'time-range'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :show-time="props.showTime"
      :placeholder="props.rangePlaceholder"
      @change="handleChange"
    />

    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>

<script setup>
import { useField } from 'vee-validate';
const emits = defineEmits(['onChange']);
const props = defineProps({
  type: {
    type: String,
    default: 'date'
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

  size: {
    type: String,
    default: 'large'
  },
  showTime: {
    type: Boolean,
    default: false
  },
  placeholder: {
    type: String,
    default: 'Vui lòng chọn thời gian'
  },
  rangePlaceholder: {
    type: Array,
    default: () => {
      return ['Chọn thời gian bắt đầu', 'Chọn thời gian kết thúc'];
    }
  }
});

const handleChange = (value) => {
  emits('onChange', value);
};

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>
