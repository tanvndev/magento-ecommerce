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
              <template v-if="column.dataIndex === 'image'">
                <img
                  class="w-20 object-contain"
                  :src="resizeImage(record.image, 100)"
                  :alt="record.name"
                />
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

              <template v-if="column.dataIndex === 'action'">
                <ActionComponent
                  @onDelete="onDelete"
                  :id="record.id"
                  :routeUpdate="state.routeUpdate"
                  :endpoint="state.endpoint"
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
  ToolboxComponent,
  ActionComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { resizeImage } from '@/utils/helpers';

// STATE
const state = reactive({
  pageTitle: 'Danh sách thương hiệu',
  modelName: 'Brand',
  routeCreate: 'brand.store',
  routeUpdate: 'brand.update',
  endpoint: 'brands',
  isShowToolbox: false,
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

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
  },
  {
    title: 'Thực thi',
    dataIndex: 'action',
    key: 'action',
    width: '6%'
  }
];

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
    ...state.filterOptions
  };
  const response = await getAll(state.endpoint, payload);
  state.dataSource = response.data;
  pagination.current = response.current_page;
  pagination.total = response.total;
  pagination.pageSize = response.per_page;
};

// Watchers
watch(onChangePagination, () => fetchData());
watch(selectedRows, () => {
  state.isShowToolbox = selectedRows.value.length > 0;
  state.modelIds = selectedRowKeys.value;
});

const onFilterOptions = (filterValue) => {
  state.filterOptions = filterValue;
  fetchData();
};

const onChangeToolbox = () => {
  fetchData();
};

const onDelete = (key) => {
  state.dataSource = state.dataSource.filter((item) => item.key !== key);
};

// Lifecycle hook
onMounted(fetchData);
</script>
