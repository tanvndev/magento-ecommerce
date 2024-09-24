<template>
  <a-radio-group
    v-model:value="value"
    :disabled="props.disabled"
    :size="props.size"
    :options="props.options"
    :optionType="props.optionType"
    :button-style="props.buttonStyle"
    @change="handleChange"
  >
  </a-radio-group>
</template>
<script setup>
import { useField } from 'vee-validate';
import { watch } from 'vue';

const emits = defineEmits(['onChange']);
const props = defineProps({
  options: {
    type: Array,
    default: () => []
  },
  optionType: {
    type: String,
    default: 'default'
  },
  required: {
    type: [Boolean, String],
    default: false
  },
  name: {
    type: String,
    required: true
  },
  size: {
    type: String,
    default: 'default'
  },
  oldValue: {
    type: [String, Boolean, Number],
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  },
  buttonStyle: {
    type: String,
    default: 'outline'
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);

const handleChange = (value) => {
  emits('onChange', value);
};

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
