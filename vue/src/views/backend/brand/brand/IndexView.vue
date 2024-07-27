<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="pageTitle" />

        <!-- Toolbox -->
        <ToolboxComponent
          :routeCreate="routeCreate"
          :modelName="modelName"
          :isShowToolbox="isShowToolbox"
          :modelIds="modelIds"
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
            :data-source="dataSource"
            :row-selection="rowSelection"
            :pagination="pagination"
            :loading="loading"
            @change="handleTableChange"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.dataIndex === 'image'">
                <img class="w-20 object-contain" :src="record.image" :alt="record.name" />
              </template>

              <template v-if="column.dataIndex === 'publish'">
                <PublishSwitchComponent
                  :record="record"
                  :modelName="modelName"
                  :field="column.dataIndex"
                />
              </template>

              <template v-if="column.dataIndex === 'action'">
                <ActionComponent
                  @onDelete="onDelete"
                  :id="record.id"
                  :routeUpdate="routeUpdate"
                  :endpoint="endpoint"
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
import { onMounted, ref, watch } from 'vue';
import {
  BreadcrumbComponent,
  MasterLayout,
  FilterComponent,
  PublishSwitchComponent,
  ToolboxComponent,
  ActionComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';

// Data static
const pageTitle = 'Danh sách thương hiệu';
const modelName = 'Brand';
const routeCreate = 'brand.store';
const routeUpdate = 'brand.update';
const endpoint = 'brands';
const columns = [
  {
    title: 'Ảnh',
    dataIndex: 'image',
    key: 'image',
    width: '10%'
  },
  {
    title: 'Tên thương hiệu',
    dataIndex: 'name',
    key: 'name',
    sorter: (a, b) => a.name.localeCompare(b.name)
  },
  {
    title: 'Đường dẫn',
    dataIndex: 'canonical',
    key: 'canonical',
    sorter: (a, b) => a.canonical.localeCompare(b.canonical)
  },
  {
    title: 'Tình trạng',
    dataIndex: 'publish',
    key: 'publish',
    width: '7%'
  },
  {
    title: 'Thực thi',
    dataIndex: 'action',
    key: 'action',
    width: '6%'
  }
];

// Data
const filterOptions = ref({});
const dataSource = ref([]);
const isShowToolbox = ref(false);
const modelIds = ref([]);

// Fetch
const { getAll, loading } = useCRUD();
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
    ...filterOptions.value
  };
  const response = await getAll(endpoint, payload);
  dataSource.value = response.data;
  pagination.current = response.current_page;
  pagination.total = response.total;
  pagination.pageSize = response.per_page;
};

// Watchers
watch(onChangePagination, () => fetchData());
watch(selectedRows, () => {
  isShowToolbox.value = selectedRows.value.length > 0;
  modelIds.value = selectedRowKeys.value;
});

const onFilterOptions = (filterValue) => {
  filterOptions.value = filterValue;
  fetchData();
};

const onChangeToolbox = () => {
  fetchData();
};

const onDelete = (key) => {
  dataSource.value = dataSource.value.filter((item) => item.key !== key);
};

// Lifecycle hook
onMounted(fetchData);
</script>
