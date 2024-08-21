<template>
    <MasterLayout>
        <template #template>
            <div class="container mx-auto h-screen">
                <BreadcrumbComponent :titlePage="state.pageTitle" />

                <!-- Toolbox -->
                <ToolboxComponent :routeCreate="state.routeCreate" :modelName="state.modelName"
                    :isShowToolbox="state.isShowToolbox" :modelIds="state.modelIds"
                    @onChangeToolbox="onChangeToolbox" />
                <!-- End toolbox -->

                <!-- Filter -->
                <FilterComponent @onFilter="onFilterOptions" />
                <!-- End filter -->

                <!-- Table -->
                <a-card class="mt-3">
                    <a-table bordered :columns="columns" :data-source="state.dataSource" :row-selection="rowSelection"
                        :pagination="pagination" :loading="loading" @change="handleTableChange">
                        <template #bodyCell="{ column, record }">
                            <template v-if="column.dataIndex === 'name'">
                                <RouterLink class="text-primary-500"
                                    :to="{ name: 'attribute.update', params: { id: record.id } }">
                                    {{ record.name }}
                                </RouterLink>
                            </template>
                        </template>

                        <template #expandedRowRender="{ record }">
                            <h2>Giá trị thuộc tính </h2>
                            <ul class="mb-0 mt-3 ml-10 list-disc flex gap-x-7 gap-y-3 flex-wrap"
                                v-if="record.values.length">
                                <li class="text-primary-500" v-for="value in record.values" :key="value.id">
                                    <RouterLink :to="{ name: 'attribute.value.update', params: { id: value.id } }">
                                        {{ value.name }}
                                    </RouterLink>
                                </li>
                            </ul>
                            <div class="text-red-500 ml-10" v-else>Chưa có giá trị thuộc tính</div>
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
    ToolboxComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';

// STATE
const state = reactive({
    pageTitle: 'Danh sách thuộc tính',
    modelName: 'Attribute',
    routeCreate: 'attribute.store',
    routeUpdate: 'attribute.update',
    endpoint: 'attributes',
    isShowToolbox: false,
    modelIds: [],
    filterOptions: {},
    dataSource: []
});

const columns = [
    {
        title: 'Tên thuộc tính',
        dataIndex: 'name',
        key: 'name',
        sorter: (a, b) => a.name.localeCompare(b.name)
    },
    {
        title: 'Mã thuộc tính',
        dataIndex: 'code',
        key: 'code',
        sorter: (a, b) => a.code.localeCompare(b.code)
    },
    {
        title: 'Mô tả thuộc tính',
        dataIndex: 'description',
        key: 'description',
        sorter: (a, b) => a.description.localeCompare(b.description)
    },


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
