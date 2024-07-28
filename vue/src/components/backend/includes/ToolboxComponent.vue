<template>
  <a-card>
    <a-space :size="12" class="flex justify-end">
      <div v-if="props.isShowToolbox">
        <a-dropdown trigger="click" class="mr-3" v-if="removeRouteHide()">
          <a-button class="h-[37px]">
            <i class="far fa-tools mr-2"></i>
            <span>Công cụ</span>
          </a-button>
          <template #overlay>
            <a-menu>
              <a-menu-item>
                <a-popconfirm
                  title="Bạn có chắc chắn muốn xuất bản toàn bộ không?"
                  ok-text="Xác nhận"
                  cancel-text="Hủy"
                  @confirm="handleChangePublish(1)"
                >
                  <a-button type="link" class="block w-full text-left text-black">
                    <span>Xuất bản toàn bộ</span>
                  </a-button>
                </a-popconfirm>
              </a-menu-item>
              <a-menu-item>
                <a-popconfirm
                  title="Bạn có chắc chắn muốn hủy xuất bản toàn bộ không?"
                  ok-text="Xác nhận"
                  cancel-text="Hủy"
                  @confirm="handleChangePublish(2)"
                >
                  <a-button type="link" class="block w-full text-left text-black">
                    <span>Hủy xuất bản toàn bộ</span>
                  </a-button>
                </a-popconfirm>
              </a-menu-item>
            </a-menu>
          </template>
        </a-dropdown>

        <a-popconfirm
          title="Bạn có chắc chắn muốn xóa không?"
          ok-text="Xóa"
          cancel-text="Hủy"
          @confirm="handleDeleteMultiple"
        >
          <a-button danger type="primary" class="h-[36px]">
            <i class="fas fa-trash-alt mr-2"></i>
            <span>Xóa</span>
          </a-button>
        </a-popconfirm>
      </div>
      <RouterLink
        :to="{ name: props.routeCreate }"
        class="rounded-[6px] border border-emerald-500 px-[16px] py-[9px] text-emerald-500 hover:bg-emerald-500 hover:text-white"
      >
        <i class="fas fa-plus mr-2"></i>
        <span>Thêm mới</span>
      </RouterLink>

      <RouterLink
        v-if="route.name === 'user.catalogue.index'"
        :to="{ name: 'user.catalogue.permission' }"
        class="rounded-[6px] border border-orange-400 px-[16px] py-[9px] text-orange-400 hover:bg-orange-400 hover:text-white"
      >
        <i class="fas fa-key-skeleton mr-2"></i>
        <span>Phân Quyền</span>
      </RouterLink>
    </a-space>
  </a-card>
</template>

<script setup>
import BaseService from '@/services/BaseService';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const emits = defineEmits(['onChangeToolbox']);
const route = useRoute();
const store = useStore();
const props = defineProps({
  isShowToolbox: {
    type: Boolean
  },
  routeCreate: {
    type: String,
    required: true
  },
  modelName: {
    type: String,
    required: true
  },
  modelIds: {
    type: [Object, Array]
  }
});

const handleChangePublish = async (value) => {
  const payload = {
    modelName: props.modelName,
    modelIds: props.modelIds,
    field: 'publish',
    value
  };

  const response = await BaseService.changeStatusAll(payload);
  const type = response.success ? 'success' : 'error';
  emits('onChangeToolbox');
  store.dispatch('antStore/showMessage', { type, message: response.messages });
};

const removeRouteHide = () => {
  const routeHide = ['permission.index', 'supplier.index', 'attribute.index'];
  if (routeHide.includes(route.name)) {
    return false;
  }
  return true;
};

const handleDeleteMultiple = async () => {
  const payload = {
    modelName: props.modelName,
    modelIds: props.modelIds
  };
  const response = await BaseService.deleteMultiple(payload);
  const type = response.success ? 'success' : 'error';
  emits('onChangeToolbox');
  store.dispatch('antStore/showMessage', { type, message: response.messages });
};
</script>
