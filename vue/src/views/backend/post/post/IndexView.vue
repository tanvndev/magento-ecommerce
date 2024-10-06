<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />

        <!-- Toolbox -->
        <ToolboxComponent
          :routeCreate="state.routeCreate"
          :modelName="state.modelName"
          :isShowToolbox="state.isShowToolbox"
          :modelIds="state.modelIds"
          @onChangeToolbox="onChangeToolbox"
        />
        <!-- End toolbox -->

        <!-- Filter -->
        <FilterComponent @onFilter="onFilterOptions" />
        <!-- End filter -->

        <!-- Table -->
        <a-card class="mt-3">
          <a-table
            bordered
            :columns="columns"
            :data-source="state.dataSource"
            :row-selection="rowSelection"
            :pagination="pagination"
            :loading="loading"
            @change="handleTableChange"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'name'">
                <div class="flex items-center">
                  <div class="rounded border p-1">
                    <img
                      class="h-[50px] w-[50px] object-cover"
                      :src="resizeImage(record.image, 100)"
                    />
                  </div>
                  <RouterLink
                    :to="{
                      name: 'product.update',
                      params: { id: record.product_id },
                      query: { variant_id: record.id }
                    }"
                    class="ml-2 text-blue-500"
                    >{{ record.name }}</RouterLink
                  >
                </div>
              </template>

              <template v-if="column.dataIndex === 'publish'">
                <StatusSwitchComponent
                  :record="record"
                  :modelName="state.modelName"
                  :field="column.dataIndex"
                />
              </template>

              <template v-if="column.dataIndex === 'is_featured'">
                <StatusSwitchComponent
                  :record="record"
                  :modelName="state.modelName"
                  :field="column.dataIndex"
                />
              </template>
            </template>
          </a-table>
        </a-card>
        <!-- End table -->
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { onMounted, reactive, watch } from 'vue';
import {
  BreadcrumbComponent,
  MasterLayout,
  FilterComponent,
  StatusSwitchComponent,
  ToolboxComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { debounce, resizeImage } from '@/utils/helpers';
import { useRoute } from 'vue-router';

// STATE
const state = reactive({
  pageTitle: 'Danh sách bài viết',
  modelName: 'Post',
  routeCreate: 'post.store',
  routeUpdate: 'post.update',
  endpoint: 'posts',
  isShowToolbox: false,
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

const columns = [
  {
    title: 'Bài viết',
    dataIndex: 'name',
    key: 'name'
  },
  {
    title: 'Đường dẫn',
    dataIndex: 'canonical',
    key: 'canonical',
    sorter: (a, b) => a.canonical.localeCompare(b.canonical)
  },
  {
    title: 'Nổi bật',
    dataIndex: 'is_featured',
    key: 'is_featured',
    width: '5%'
  },
  {
    title: 'Tình trạng',
    dataIndex: 'publish',
    key: 'publish',
    width: '7%'
  }
];

const { getAll, loading } = useCRUD();
const route = useRoute();

// Pagination
const {
  pagination,
  rowSelection,
  handleTableChange,
  onChangePagination,
  selectedRowKeys,
  selectedRows
} = usePagination();

// Fetchdata
const fetchData = async () => {
  const payload = {
    page: pagination.current,
    pageSize: pagination.pageSize,
    ...state.filterOptions
  };
  const response = await getAll(state.endpoint, payload);
  state.dataSource = response.data;
  pagination.current = response.current_page;
  pagination.total = response.total;
  pagination.pageSize = response.per_page;
};

const deboucedFetchData = debounce(fetchData, 500);

// Watchers
watch(onChangePagination, () => fetchData());
watch(selectedRows, () => {
  state.isShowToolbox = selectedRows.value.length > 0;
  state.modelIds = selectedRowKeys.value;
});
watch(
  () => route.query.archive,
  (newValue) => {
    state.filterOptions.archive = newValue === 'true' ? true : false;
    state.pageTitle =
      newValue === 'true' ? 'Danh sách lưu trữ thương hiệu' : 'Danh sách thương hiệu';
    deboucedFetchData();
  }
);

const onFilterOptions = (filterValue) => {
  state.filterOptions = filterValue;
  fetchData();
};

const onChangeToolbox = () => {
  fetchData();
};

// Lifecycle hook
onMounted(fetchData);
</script>
