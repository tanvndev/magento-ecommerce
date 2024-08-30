<template>
  <a-card title="Thông số kĩ thuật" class="mt-3">
    <a-row :gutter="[16, 10]" class="items-center">
      <a-col span="24">
        <SelectComponent
          name="attribute_id"
          label="Thuộc tính"
          placeholder="Chọn thuộc tính"
          :options="formatDataToSelect(props.attributeData)"
          mode="multiple"
          @onChange="handleSelectedAttribute"
        />
      </a-col>

      <a-divider v-if="attributeValues">Chọn Giá Trị Cho Thuộc Tính </a-divider>
      <!-- Value -->
      <a-col span="24" v-if="attributeValues">
        <div
          class="mb-4 flex items-center"
          v-for="attributeValue in attributeValues"
          :key="attributeValue.id"
        >
          <div class="mr-2 w-32">
            <span class="block text-gray-500">Tên:</span>
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
  </a-card>
</template>

<script setup>
import { ref, watch } from 'vue';
import { SelectComponent } from '@/components/backend';
import { formatDataToSelect } from '@/utils/format';

const props = defineProps({
  attributeNotEnableOld: {
    type: Array,
    default: () => []
  },
  attributeNotEnableIds: {
    type: Array,
    default: () => []
  },
  attributeData: {
    type: [Object, Array],
    default: () => []
  }
});

// STATE
const attributeValues = ref([]);

const handleSelectedAttribute = (attributeIds) => {
  attributeValues.value = attributeIds.map((id) =>
    props.attributeData.find((item) => item.id === id)
  );
};

const getSelectedOldValues = (attributeId) => {
  const oldAttribute = props.attributeNotEnableOld.find(
    (attr) => attr.attribute_id === attributeId
  );
  return oldAttribute ? oldAttribute.attribute_value_ids : [];
};

watch(
  () => props.attributeNotEnableIds,
  (newIds) => {
    handleSelectedAttribute(newIds);
  },
  { immediate: true }
);
</script>
