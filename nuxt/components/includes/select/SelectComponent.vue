<template>
  <v-select
    v-if="!props.autocomplete"
    v-model="value"
    :items="props.items"
    :hint="props.hint"
    :error-messages="errorMessage"
    :variant="props.variant"
    :density="props.density"
    :label="props.label"
    :clearable="props.clearable"
    no-data-text="Không có dữ liệu."
  ></v-select>

  <v-autocomplete
    v-if="props.autocomplete"
    v-model="value"
    :items="props.items"
    :hint="props.hint"
    :error-messages="errorMessage"
    :variant="props.variant"
    :density="props.density"
    :label="props.label"
    :clearable="props.clearable"
    no-data-text="Không có dữ liệu."
  ></v-autocomplete>
</template>

<script setup>
import { useField } from 'vee-validate'
import { watch } from 'vue'

const emits = defineEmits(['onChange'])
const props = defineProps({
  autocomplete: {
    type: Boolean,
    default: true,
  },
  label: {
    type: String,
    default: '',
  },
  items: {
    type: Array,
    default: () => [
      'California',
      'Colorado',
      'Florida',
      'Georgia',
      'Texas',
      'Wyoming',
    ],
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
  clearable: {
    type: Boolean,
    default: false,
  },
  hint: {
    type: String,
    default: '',
  },
})

const { value, errorMessage } = useField(props.name)

// Watch for changes in oldValue and set value accordingly
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

<style scoped>
.ant-select-selection-item-remove {
  display: none;
}
</style>
