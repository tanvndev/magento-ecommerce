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
              <template v-if="column.dataIndex === 'catalogue_name'">
                <a-tag color="blue">{{ record.catalogue_name }}</a-tag>
              </template>

              <template v-if="column.dataIndex === 'publish'">
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

// STATE
const state = reactive({
  pageTitle: 'Danh sách thành viên',
  modelName: 'User',
  routeCreate: 'user.store',
  routeUpdate: 'user.update',
  endpoint: 'users',
  isShowToolbox: false,
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

const columns = [
  {
    title: 'Tên thành viên',
    dataIndex: 'fullname',
    key: 'fullname',
    sorter: (a, b) => a.fullname.localeCompare(b.fullname)
  },
  {
    title: 'Nhóm thành viên',
    dataIndex: 'catalogue_name',
    key: 'catalogue_name'
  },
  {
    title: 'Địa chỉ email',
    dataIndex: 'email',
    key: 'email',
    sorter: (a, b) => a.email.localeCompare(b.email)
  },
  {
    title: 'Số điện thoại',
    dataIndex: 'phone',
    key: 'phone',
    sorter: (a, b) => a.phone.localeCompare(b.phone)
  },
  {
    title: 'Địa chỉ',
    dataIndex: 'address',
    key: 'address'
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
