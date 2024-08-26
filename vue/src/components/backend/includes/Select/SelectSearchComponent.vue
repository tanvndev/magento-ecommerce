<template>
  <label v-if="props.label" :for="props.name" :class="props.labelClass"
    >{{ props.label }}
    <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
    <TooltipComponent v-if="props.tooltipText" :title="props.tooltipText" />
  </label>
  <div>
    <a-select
      :id="props.name"
      :size="props.size"
      :show-search="props.showSearch"
      v-model:value="value"
      :allowClear="true"
      :autoClearSearchValue="true"
      :options="options"
      :placeholder="props.placeholder"
      :class="props.className"
      :mode="props.mode"
      :status="errorMessage ? 'error' : ''"
      @change="handleChange"
    >
    </a-select>
    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>
</template>

<script setup>
import { useField } from 'vee-validate';
import { TooltipComponent } from '@/components/backend';
import { ref } from 'vue';
import { debounce } from '@/utils/helpers';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';

const { getAll, data } = useCRUD();

const options = ref([]);
const props = defineProps({
  endpoint: {
    type: String,
    default: ''
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
  showSearch: {
    type: [Boolean, String],
    default: true
  },
  mode: {
    type: String,
    default: 'default'
  },
  tooltipText: {
    type: String,
    default: ''
  }
});

const getData = async (value) => {
  if (props.endpoint === '') {
    return [];
  }
  const payload = {
    search: value
  };
  await getAll(props.endpoint, payload);
  options.value = formatDataToSelect(data.value);
};
const debouncedHandleChange = debounce((value) => {
  getData(value);
}, 500);

const handleChange = (value) => {
  debouncedHandleChange(value);
};

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>

<style scoped>
.ant-select-selection-item-remove {
  display: none;
}
</style>
