<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="pageTitle" />
        <a-card class="mt-3">
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full border-collapse text-left text-sm text-gray-500">
              <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:text-gray-400">
                <tr>
                  <th>Tên quyền</th>
                  <th
                    class="text-center"
                    v-for="userCatalogue in userCatalogues"
                    :key="userCatalogue.key + 'userCatalogues'"
                  >
                    {{ userCatalogue.name }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="border-b bg-white hover:bg-gray-50"
                  v-for="permission in permissions"
                  :key="permission.key + 'permission'"
                >
                  <td>
                    <div class="flex justify-between">
                      <span class="text-blue-500">{{ permission.name }}</span>
                      <span class="text-orange-500">({{ permission.canonical }})</span>
                    </div>
                  </td>

                  <td
                    class="text-center"
                    v-for="userCatalogue in userCatalogues"
                    :key="userCatalogue.id + 'checkbox'"
                  >
                    <label class="container-cbx">
                      <input
                        type="checkbox"
                        :checked="isChecked(userCatalogue.id, permission.id)"
                        @change="handleChecked(userCatalogue, permission.id)"
                      />
                      <div class="checkmark"></div>
                    </label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="fixed bottom-[40px] right-[40px]">
            <a-button @click="onSubmit" :loading="loading" type="primary">
              <i class="far fa-save mr-2"></i>
              <span>Lưu thông tin</span>
            </a-button>
          </div>
        </a-card>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { BreadcrumbComponent, MasterLayout } from '@/components/backend';
import { useCRUD } from '@/composables';
import { useStore } from 'vuex';

// Data static
const pageTitle = 'Cập nhập phân quyền người dùng';
const endpoint = 'users/catalogues/permissions';

const store = useStore();
const { getAll, update, loading, data, messages } = useCRUD();

const permissions = ref(null);
const userCatalogues = ref(null);
const permissionChecked = ref({});

const isChecked = (userCatalogueId, permissionId) => {
  if (!permissions.value || !userCatalogues.value) return false;

  const userCatalogue = userCatalogues.value.find((uc) => uc.id === userCatalogueId);
  if (!userCatalogue) return false;

  return userCatalogue.permissions.some((p) => p.id === permissionId);
};

const onSubmit = async () => {
  const formData = new FormData();
  formData.append('permissions', JSON.stringify(permissionChecked.value));
  await update(endpoint, 1, formData);

  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
};

const handleChecked = (userCatalogue, permissionId) => {
  if (!permissionChecked.value[userCatalogue.id]) {
    permissionChecked.value[userCatalogue.id] = [];
  }

  const index = permissionChecked.value[userCatalogue.id].indexOf(permissionId);
  if (index === -1) {
    permissionChecked.value[userCatalogue.id].push(permissionId);
  } else {
    permissionChecked.value[userCatalogue.id].splice(index, 1);
  }

  console.log(permissionChecked.value);
};

const getPermissions = async () => {
  await getAll('permissions');
  permissions.value = data.value;
};

const getUserCatalogues = async () => {
  await getAll('users/catalogues');

  data.value.forEach((userCatalogue) => {
    const permissionIds = userCatalogue.permissions.map((p) => p.id);
    permissionChecked.value[userCatalogue.id] = permissionIds;
  });

  // Gán userCatalogues.value từ data.value
  userCatalogues.value = data.value;
};

// Lifecycle hook
onMounted(() => {
  getPermissions();
  getUserCatalogues();
});
</script>

<style scoped>
.container-cbx {
  width: 35px;
  height: 35px;
  display: inline-block;
}

.checkmark::after {
  left: 0.96em;
  top: 0.7em;
  width: 0.4em;
  height: 0.8em;
}
thead th {
  text-align: center;
  font-weight: bold;
  font-size: 15px;
  padding: 16px 24px;
}
tbody td {
  padding: 16px 24px;
  text-align: center;
  font-size: 15px;
}
</style>
