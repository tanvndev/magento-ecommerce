<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span></label
  >
  <div>
    <a-tree-select
      v-model:value="value"
      :id="props.name"
      :size="props.size"
      :show-search="props.showSearch"
      :allowClear="true"
      :autoClearSearchValue="true"
      :placeholder="props.placeholder"
      :tree-data="props.options"
      :class="props.className"
      :status="errorMessage ? 'error' : ''"
      :mode="props.mode"
      :tree-default-expand-all="props.treeDefaultExpandAll"
      :multiple="props.multiple"
      :show-checked-strategy="SHOW_ALL"
      tree-node-filter-prop="label"
      @change="handleChange"
    >
    </a-tree-select>
    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>

<script setup>
import { useField } from 'vee-validate';
import { TreeSelect } from 'ant-design-vue';
const SHOW_ALL = TreeSelect.SHOW_ALL;
const emits = defineEmits(['onChange']);
const props = defineProps({
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
  options: {
    type: [Array, Object],
    default: () => []
  },
  showSearch: {
    type: [Boolean, String],
    default: true
  },
  mode: {
    type: String,
    default: 'default'
  },
  treeDefaultExpandAll: {
    type: Boolean,
    default: true
  },
  multiple: {
    type: Boolean,
    default: true
  }
});

const handleChange = (value) => {
  emits('onChange', value);
};

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>

<style scoped>
.ant-select-selection-item-remove {
  display: none;
}
</style>
