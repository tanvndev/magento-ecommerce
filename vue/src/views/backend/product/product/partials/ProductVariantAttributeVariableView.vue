<template>
  <form>
    <a-button @click="state.open = true" type="dashed">Sửa thuộc tính</a-button>
    <a-modal v-model:open="state.open" width="1000px" title="Cập nhập thuộc tính">
      <a-row :gutter="[16, 10]" class="items-center">
        <a-divider v-if="state.attributeValues.length">Chọn Giá Trị Cho Thuộc Tính </a-divider>
        <a-col span="24" v-if="state.attributeValues.length">
          <div
            class="mb-4 flex items-center"
            v-for="(attributeValue, index) in state.attributeValues"
            :key="index"
          >
            <div class="mr-2 w-32">
              <span class="font-bold">{{ attributeValue?.name }}</span>
            </div>

            <div class="w-full">
              <SelectComponent
                :name="`attribute_attribute_value_ids[${attributeValue?.id}]`"
                :placeholder="`Chọn giá trị thuộc tính của thuộc tính ${attributeValue?.name}`"
                :options="formatDataToSelect(attributeValue?.values || [])"
                :oldValue="getSelectedOldValues(attributeValue?.id)"
                mode="multiple"
              />
            </div>
          </div>
        </a-col>
      </a-row>
      <template #footer>
        <a-button @click="state.open = false">Hủy bỏ</a-button>
        <a-button html-type="submit" @click="onSubmit" type="primary">Lưu lại</a-button>
      </template>
    </a-modal>
  </form>
</template>

<script setup>
import { reactive, watch } from 'vue';
import { SelectComponent } from '@/components/backend';
import { formatDataToSelect } from '@/utils/format';
import { useForm } from 'vee-validate';
import * as yup from 'yup';
import { useCRUD } from '@/composables';

const { create, messages } = useCRUD();
const props = defineProps({
  attributeData: {
    type: Array,
    default: () => []
  },
  attributeEnableOld: {
    type: Array,
    default: () => []
  },
  attributeEnableIds: {
    type: Array,
    default: () => []
  }
});

// STATE
const state = reactive({
  open: false,
  attributeValues: []
});

const { handleSubmit } = useForm({
  //   validationSchema: yup.object({
  //     name: yup.string().required('Tên nhóm sản phẩm không được để trống.')
  //   })
});

const onSubmit = handleSubmit(async (values) => {
  console.log(values);

  //   const response = await create(state.endpoint, values);
  //   if (!response) {
  //     return;
  //   }
});

const handleSelectedAttribute = (attributeIds) => {
  state.attributeValues = attributeIds.map((id) =>
    props.attributeData.find((item) => item.id == id)
  );
};

const getSelectedOldValues = (attributeId) => {
  const oldAttribute = props.attributeEnableOld.find((attr) => attr.attribute_id == attributeId);
  return oldAttribute ? oldAttribute.attribute_value_ids : [];
};

watch(
  () => props.attributeEnableIds,
  (newIds) => {
    handleSelectedAttribute(newIds);
  },
  { immediate: true }
);
</script>
