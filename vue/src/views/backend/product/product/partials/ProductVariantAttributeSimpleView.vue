<template>
  <form>
    <a-button @click="state.open = true" type="dashed">Sửa thuộc tính</a-button>
    <a-modal v-model:open="state.open" width="1000px" title="Cập nhập thuộc tính">
      <a-row :gutter="[16, 10]" class="items-center">
        <a-col :span="24" class="mt-4">
          <SelectComponent
            name="attribute_id"
            label="Thuộc tính"
            placeholder="Chọn thuộc tính"
            :options="state.attributeOptions"
            mode="multiple"
            :disabled="state.attributeIds.length >= 5"
            @onChange="handleSelectedAttribute"
          />
        </a-col>
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
                mode="multiple"
              />
            </div>
          </div>
        </a-col>
      </a-row>
      <template #footer>
        <a-button @click="state.open = false">Hủy bỏ</a-button>
        <a-popconfirm
          title="Bạn có chắc chắn muốn xóa phiên bản cũ để cập nhập phiên bản mới."
          ok-text="Lưu lại"
          cancel-text="Hủy bỏ"
          @confirm="onSubmit"
        >
          <a-button type="primary">Lưu lại</a-button>
        </a-popconfirm>
      </template>
    </a-modal>
  </form>
</template>

<script setup>
import { computed, reactive } from 'vue';
import { SelectComponent } from '@/components/backend';
import { formatDataToSelect } from '@/utils/format';
import { useForm } from 'vee-validate';
import router from '@/router';
import { useCRUD } from '@/composables';
import { message } from 'ant-design-vue';

const { update, messages } = useCRUD();
const id = computed(() => router.currentRoute.value.params.id || null);
const emits = defineEmits(['onReload']);
const props = defineProps({
  attributeData: {
    type: Array,
    default: () => []
  }
});

// STATE
const state = reactive({
  open: false,
  attributeIds: [],
  attributeValues: [],
  attributeOptions: formatDataToSelect(props.attributeData),
  endpoint: 'products/attributes/update'
});

const { handleSubmit } = useForm();

const onSubmit = handleSubmit(async (values) => {
  if (!id.value) {
    return message.warn('Có lỗi vui lòng tải lại trang.');
  }

  const response = await update(state.endpoint, id.value, values);

  if (!response) {
    return message.error(messages.value);
  }

  state.open = false;
  emits('onReload');
  message.success(messages.value);
});

const handleSelectedAttribute = (attributeIds) => {
  state.attributeIds = attributeIds;
  if (attributeIds.length >= 3 && state.attributeValues.length >= 3) {
    message.warning('Bạn chỉ có thể chọn tối đa 3 thuộc tính.');
    return;
  }
  state.attributeValues = attributeIds.map((id) =>
    props.attributeData.find((item) => item.id == id)
  );
};
</script>
