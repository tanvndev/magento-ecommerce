<template>
  <a-space>
    <RouterLink
      class="rounded-[6px] border border-yellow-500 px-[14px] py-[7px] text-yellow-500 hover:bg-yellow-500 hover:text-white"
      :to="{ name: routeUpdate, params: { id: props.id } }"
    >
      <i class="fas fa-edit"></i
    ></RouterLink>
    <a-popconfirm title="Bạn có chắc chắn muốn xóa?" @confirm="handleDelete(props.id)">
      <button
        class="rounded-[6px] border border-red-500 px-[16px] py-[4px] text-red-500 hover:bg-red-500 hover:text-white"
      >
        <i class="fas fa-trash-alt"></i>
      </button>
    </a-popconfirm>
  </a-space>
</template>

<script setup>
import { useStore } from 'vuex';
import { BaseService } from '@/services';

const store = useStore();
const emits = defineEmits(['onDelete']);
const props = defineProps({
  id: [Number, String],
  routeUpdate: {
    type: String,
    required: true
  },
  endpoint: {
    type: String,
    required: true
  }
});

const handleDelete = async (id) => {
  const response = await BaseService.deleteOne(props.endpoint, id);

  const type = response.success ? 'success' : 'error';
  store.dispatch('antStore/showMessage', { type, message: response.messages });
  emits('onDelete', id);
};
</script>
