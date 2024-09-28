<template>
  <a-card>
    <a-space :size="12" class="flex justify-end">
      <div v-if="props.isShowToolbox">
        <a-dropdown trigger="click" class="mr-3" v-if="removeRouteHide()">
          <a-button class="h-[37px]" v-if="!hasArchive">
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

        <a-dropdown trigger="click" class="" v-if="removeRouteHide()">
          <a-button danger class="h-[36px]">
            <i class="fas fa-trash-alt mr-2"></i>
            <span>Thùng rác</span>
          </a-button>
          <template #overlay>
            <a-menu>
              <a-menu-item v-if="hideArchive()">
                <!-- Khôi phục Lưu trữ -->
                <a-popconfirm
                  v-if="hasArchive"
                  title="Bạn có chắc chắn muốn hủy hủy lưu trữ toàn bộ không?"
                  ok-text="Xác nhận"
                  cancel-text="Hủy"
                  @confirm="handleArchive()"
                >
                  <a-button type="link" class="block w-full text-left text-black">
                    <span>Hủy lưu trữ toàn bộ</span>
                  </a-button>
                </a-popconfirm>

                <!-- Luu trữ -->
                <a-popconfirm
                  v-else
                  title="Bạn có chắc chắn muốn lưu trữ toàn bộ không?"
                  ok-text="Xác nhận"
                  cancel-text="Hủy"
                  @confirm="handleDeleteMultiple(0)"
                >
                  <a-button type="link" class="block w-full text-left text-black">
                    <span>Lưu trữ toàn bộ</span>
                  </a-button>
                </a-popconfirm>
              </a-menu-item>
              <a-menu-item>
                <a-popconfirm
                  title="Bạn có chắc chắn muốn xuất bản toàn bộ không?"
                  ok-text="Xác nhận"
                  cancel-text="Hủy"
                  @confirm="handleDeleteMultiple(1)"
                >
                  <a-button type="link" class="block w-full text-left text-black">
                    <span>Xóa toàn bộ</span>
                  </a-button>
                </a-popconfirm>
              </a-menu-item>
            </a-menu>
          </template>
        </a-dropdown>
      </div>

      <a
        v-if="hideArchive()"
        href="#"
        @click.prevent="handleChangeArchive"
        class="rounded-[6px] border border-orange-500 px-[16px] py-[9px] text-orange-500 hover:bg-orange-500 hover:text-white"
        :class="{ 'bg-orange-500 text-white': hasArchive }"
      >
        <i class="fas fa-archive mr-2"></i>
        <span>Lưu trữ</span>
      </a>

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
import { useRoute, useRouter } from 'vue-router';
import { message } from 'ant-design-vue';
import { ref } from 'vue';

const emits = defineEmits(['onChangeToolbox']);
const route = useRoute();
const router = useRouter();
const hasArchive = ref(false);
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
  message[type](response.messages);
};

const handleChangeArchive = () => {
  const currentQuery = { ...route.query };

  if (currentQuery.archive === 'true') {
    hasArchive.value = false;
    delete currentQuery.archive;
  } else {
    hasArchive.value = true;
    currentQuery.archive = 'true';
  }

  router.push({ path: route.path, query: currentQuery });
};

const handleArchive = async () => {
  const payload = {
    modelName: props.modelName,
    modelIds: props.modelIds
  };
  const response = await BaseService.archiveMultiple(payload);
  const type = response.success ? 'success' : 'error';

  emits('onChangeToolbox');
  message[type](response.messages);
};

const removeRouteHide = () => {
  const routeHide = ['permission.index', 'attribute.index', 'order.index'];
  if (routeHide.includes(route.name)) {
    return false;
  }
  return true;
};

const hideArchive = () => {
  const routeHide = ['attribute.index', 'permission.index', 'order.index'];
  if (routeHide.includes(route.name)) {
    return false;
  }
  return true;
};

const handleDeleteMultiple = async (force = 0) => {
  const payload = {
    modelName: props.modelName,
    modelIds: props.modelIds,
    forceDelete: force
  };
  const response = await BaseService.deleteMultiple(payload);
  const type = response.success ? 'success' : 'error';

  emits('onChangeToolbox');
  message[type](response.messages);
};
</script>
