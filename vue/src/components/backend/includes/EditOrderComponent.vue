<template>
  <div v-if="editableData[record.key]" class="flex items-center">
    <a-input v-model:value="editableData[record.key].order" @keydown.enter="save(record.key)" />
    <span class="ml-2 leading-none" @click="save(record.key)">
      <i class="fas fa-save cursor-pointer text-primary-500 hover:text-primary-300"></i>
    </span>
  </div>
  <div class="flex items-center" v-else>
    <span class="text-[16px] font-bold leading-none"> {{ record.order }} </span>
    <span class="ml-2 leading-none" @click="edit(record.key)">
      <i
        class="fas fa-pencil-alt cursor-pointer border-b border-primary-500 text-[12px] text-primary-500 hover:text-primary-300"
      ></i>
    </span>
  </div>
</template>

<script setup>
import { cloneDeep } from 'lodash';
import { ref, watch } from 'vue';
import { useCRUD } from '@/composables';
import { message } from 'ant-design-vue';

const { update, messages } = useCRUD();
// Define props
const props = defineProps({
  record: {
    type: Object,
    required: true
  },
  dataSource: {
    type: Array,
    required: true
  },
  endpoint: {
    type: String,
    required: true
  }
});

const editableData = ref({});
const dataSource = ref([...props.dataSource]);

watch(
  () => props.dataSource,
  (newDataSource) => {
    dataSource.value = [...newDataSource];
    editableData.value = {};
  },
  { deep: true }
);

// Edit function
const edit = (key) => {
  const item = dataSource.value.find((item) => key === item.key);
  if (item) {
    editableData.value[key] = cloneDeep(item);
  }
};

const save = async (key) => {
  const itemIndex = dataSource.value.findIndex((item) => key === item.key);
  if (itemIndex !== -1) {
    Object.assign(dataSource.value[itemIndex], editableData.value[key]);
    delete editableData.value[key];
  }

  const payload = dataSource.value[itemIndex];
  await update(props.endpoint, key, payload);
  message.success(messages.value);
};
</script>
