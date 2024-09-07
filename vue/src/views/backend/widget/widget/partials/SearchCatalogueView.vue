<template>
  <div class="flex">
    <h1 class="text-[16px] capitalize">
      Danh sách {{ props.model == 'Brand' ? 'Thương hiệu' : 'Nhóm sản phẩm' }}
    </h1>
  </div>

  <SelectComponent
    name="model_ids"
    placeholder="Vui lòng chọn giá trị tương ứng"
    mode="multiple"
    :options="state.dataModel"
    :old-value="state.modelIds"
  />
</template>

<script setup>
import { SelectComponent } from '@/components/backend';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';
import { reactive, watch } from 'vue';
const { getAll, data } = useCRUD();

const props = defineProps({
  model: {
    type: String,
    default: ''
  },
  modelIdOld: {
    type: Array,
    default: () => []
  }
});

const state = reactive({
  dataModel: [],
  modelIds: []
});

const getDataModel = async () => {
  state.modelIds = [];
  if (!props.model) return;
  await getAll('dashboard/getDataByModel', { model: props.model });

  state.dataModel = formatDataToSelect(data.value);
};

watch(
  () => props.model,
  () => {
    getDataModel();
  },
  { immediate: true }
);

watch(
  () => props.modelIdOld,
  (newOldValue) => {
    state.modelIds = newOldValue;
  },
  { immediate: true }
);
</script>
