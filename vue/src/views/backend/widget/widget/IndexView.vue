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

              <template v-if="column.dataIndex === 'name'">
                <RouterLink
                  :to="{ name: 'widget.update', params: { id: record.id } }"
                  class="text-blue-500"
                  >{{ record.name }}</RouterLink
                >
              </template>
              <template v-if="column.dataIndex === 'type'">
                {{ typeName(record.type) }}
              </template>

              <template v-if="column.dataIndex === 'model'">
                {{ modelName(record.model) }}
              </template>

              <template v-if="column.dataIndex === 'order'">
                <EditOrderComponent
                  :record="record"
                  :dataSource="state.dataSource"
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
  EditOrderComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { resizeImage } from '@/utils/helpers';
import { RouterLink } from 'vue-router';
import { WIDGET_TYPE, WIDGET_MODEL } from '@/static/constants';

// STATE
const state = reactive({
  pageTitle: 'Danh sách widget',
  modelName: 'Widget',
  routeCreate: 'widget.store',
  routeUpdate: 'widget.update',
  endpoint: 'widgets',
  isShowToolbox: false,
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

const columns = [
  {
    title: 'Tên widget',
    dataIndex: 'name',
    key: 'name'
  },
  {
    title: 'Loại widget',
    dataIndex: 'type',
    key: 'type'
  },
  {
    title: 'Module',
    dataIndex: 'model',
    key: 'model'
  },
  {
    title: 'Vị trí',
    dataIndex: 'order',
    key: 'order',
    width: '8%'
  },
  {
    title: 'Tình trạng',
    dataIndex: 'publish',
    key: 'publish',
    width: '7%'
  }
];

const { getAll, loading } = useCRUD();

const typeName = (type) => WIDGET_TYPE.find((item) => item.value === type)?.label || '-';
const modelName = (model) => WIDGET_MODEL.find((item) => item.value === model)?.label || '-';

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

// Lifecycle hook
onMounted(fetchData);
</script>
