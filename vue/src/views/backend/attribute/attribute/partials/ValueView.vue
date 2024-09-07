<template>
    <a-card>
        <a-space :size="12" class="flex justify-between">
            <div>
                <a-button @click="state.openCreateValue = true">
                    <i class="fas fa-plus mr-2"></i> Thêm mới giá trị
                </a-button>
                <a-modal v-model:open="state.openCreateValue" title="Thêm mới giá trị" @ok="handleCreateValue">
                    <a-input v-model:value="state.attribute_values" class="w-100"
                        placeholder="Thêm nhiều cùng lúc ví dụ: Màu hồng|Màu đen|..." size="large" :allowClear="true" />
                    <span v-if="state.errors.attribute_values" class="mt-[6px] block text-[12px] text-red-500">{{
                        state.errors.attribute_values
                        }}</span>
                </a-modal>
            </div>

            <a-input-search placeholder="Nhập vào để tìm kiếm..." enter-button @search="onSearch" />
        </a-space>
    </a-card>
    <!-- End filter -->

    <!-- Table -->
    <a-table bordered :columns="columns" :data-source="state.dataSource" :pagination="pagination" :loading="loading"
        @change="handleTableChange">
        <template #bodyCell="{ column, record }">
            <template v-if="column.dataIndex === 'action'">
                <ActionComponent @onDelete="onDelete" :id="record.id" :routeUpdate="state.routeUpdate"
                    :endpoint="state.endpoint" />
            </template>
        </template>
    </a-table>
    <!-- End table -->
</template>

<script setup>
import { onMounted, reactive, watch } from 'vue';
import {
    ActionComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { message } from 'ant-design-vue';

const props = defineProps({
    attribute_id: {
        type: [Number, String,],
        required: true
    }
})

// STATE
const state = reactive({
    pageTitle: 'Danh sách giá trị thuộc tính',
    modelName: 'Attribute',
    routeCreate: 'attribute.value.store',
    routeUpdate: 'attribute.value.update',
    endpoint: 'attributes/values',
    isShowToolbox: false,
    modelIds: [],
    filterOptions: {
        search: '',
    },
    dataSource: [],
    openCreateValue: false,
    attribute_values: '',
    errors: {
        attribute_values: ''
    }
});

const columns = [
    {
        title: 'Tên giá trị thuộc tính',
        dataIndex: 'name',
        key: 'name',
        sorter: (a, b) => a.name.localeCompare(b.name)
    },
    {
        title: 'Thực thi',
        dataIndex: 'action',
        key: 'action',
        width: '6%'
    }
];

const { getAll, create, loading } = useCRUD();

// Pagination
const {
    pagination,
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
        ...state.filterOptions,
        attribute_id: props.attribute_id
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

const onSearch = (searchValue) => {
    state.filterOptions.search = searchValue;
    fetchData();
};

const handleCreateValue = async () => {
    state.errors.attribute_values = '';

    const payload = {
        attribute_id: props.attribute_id,
        name: state.attribute_values
    }

    if (payload.name === '') {
        return state.errors.attribute_values = 'Vui lòng nhập giá trị thuộc tính';
    }

    const response = await create(state.endpoint, payload);

    state.attribute_values = '';
    state.openCreateValue = false;
    if (!response) {
        return message.error('Thêm giá trị thuộc tính thất bại!');
    }
    message.success('Thêm giá trị thuộc tính thành công!');
    fetchData();

};


const onDelete = (key) => {
    state.dataSource = state.dataSource.filter((item) => item.key !== key);
};

// Lifecycle hook
onMounted(fetchData);
</script>
