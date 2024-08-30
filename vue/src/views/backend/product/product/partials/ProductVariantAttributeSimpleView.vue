<template>
  <div>
    <a-button @click="state.open = true" type="dashed">Sửa thuộc tính</a-button>
    <a-modal v-model:open="state.open" width="1000px" title="Cập nhập thuộc tính" @ok="handleOk">
      <a-row :gutter="[16, 10]" class="items-center">
        <a-col span="24">
          <SelectComponent
            name="attribute_id"
            label="Thuộc tính"
            placeholder="Chọn thuộc tính"
            :options="state.attributeOptions"
            mode="multiple"
            @onChange="handleSelectedAttribute"
          />
        </a-col>

        <a-divider v-if="state.attributeValues.length">Chọn Giá Trị Cho Thuộc Tính </a-divider>
        <!-- Value -->
        <a-col span="24" v-if="state.attributeValues.length">
          <div
            class="mb-4 flex items-center"
            v-for="(attributeValue, index) in state.attributeValues"
            :key="index"
          >
            <div class="mr-2 w-32">
              <span class="font-bold">{{ attributeValue.name }}</span>
            </div>

            <div class="w-full">
              <SelectComponent
                :name="`attribute_value_ids[${attributeValue.id}]`"
                :placeholder="`Chọn giá trị thuộc tính của thuộc tính ${attributeValue.name}`"
                :options="formatDataToSelect(attributeValue.values)"
                :oldValue="getSelectedOldValues(attributeValue.id)"
                mode="multiple"
              />
            </div>
          </div>
        </a-col>
      </a-row>
    </a-modal>
  </div>
</template>

<script setup>
import { onMounted, reactive, watch } from 'vue';
import { SelectComponent } from '@/components/backend';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';

const { getAll, data } = useCRUD();

const props = defineProps({
  attributeOld: {
    type: Array,
    default: () => []
  },
  attributeIds: {
    type: Array,
    default: () => []
  }
});
// STATE
const state = reactive({
  open: false,
  attributeOptions: [],
  attributes: [],
  attributeValues: [],
  enableVariation: {}
});

const handleSelectedAttribute = (attributeIds) => {
  state.attributeValues = attributeIds.map((id) => state.attributes.find((item) => item.id === id));
};

const getAttributes = async () => {
  await getAll('attributes');
  state.attributeOptions = formatDataToSelect(data.value);
  state.attributes = data.value;
};

const getSelectedOldValues = (attributeId) => {
  const oldAttribute = props.attributeOld.find((attr) => attr.attribute_id === attributeId);
  return oldAttribute ? oldAttribute.attribute_value_ids : [];
};

onMounted(getAttributes);

watch(
  () => props.attributeIds,
  (newIds) => {
    handleSelectedAttribute(newIds);
    // Trigger re-render of SelectComponent
    state.attributeValues = [...state.attributeValues];
  },
  { immediate: true }
);

const handleOk = () => {};
</script>
