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
    @update:search="debounceHandleChange"
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
    @update:search="debounceHandleChange"
  ></v-autocomplete>
</template>

<script setup>
import { useField } from 'vee-validate'
import { watch } from 'vue'
import { debounce } from '#imports';

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
    default: () => [],
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

const onChange = () => {
  emits('onChange', value.value)
}

const debounceHandleChange = debounce(onChange, 700)

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
