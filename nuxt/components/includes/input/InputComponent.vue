<template>
  <v-text-field
    v-if="props.typeInput == 'text'"
    v-model="value"
    clearable
    :variant="props.variant"
    :density="props.density"
    :error-messages="errorMessage"
    :disabled="props.disabled"
    :label="props.label"
    :hint="props.hint"
  ></v-text-field>

  <v-textarea
    v-if="props.typeInput == 'textarea'"
    v-model="value"
    :row-height="props.rowHeight"
    :rows="props.rows"
    :error-messages="errorMessage"
    :auto-grow="props.autoGrow"
    :variant="props.variant"
    :density="props.density"
    :label="props.label"
    :hint="props.hint"
  ></v-textarea>
</template>

<script setup>
import { useField } from 'vee-validate'
import { watch } from 'vue'

const props = defineProps({
  hint: {
    type: String,
    default: '',
  },
  typeInput: {
    type: String,
    default: 'text',
  },
  label: {
    type: String,
    default: '',
  },
  name: {
    type: String,
    required: true,
  },
  oldValue: {
    type: [String, Boolean, Number],
    default: '',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: 'outlined',
  },
  density: {
    type: String,
    default: 'comfortable',
  },
  rowHeight: {
    type: [String, Number],
    default: '15',
  },
  rows: {
    type: [String, Number],
    default: '1',
  },
  autoGrow: {
    type: Boolean,
    default: true,
  },
})

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name)

watch(
  () => props.oldValue,
  (newOldValue) => {
    if (
      newOldValue &&
      newOldValue !== undefined &&
      newOldValue !== value.value
    ) {
      value.value = newOldValue
    }
  },
  { immediate: true }
)
</script>
