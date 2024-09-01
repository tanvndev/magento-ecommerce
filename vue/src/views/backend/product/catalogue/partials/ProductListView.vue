<template>
  <a-card class="mt-3">
    <div class="flex">
      <h1 class="text-[16px] capitalize">Danh sách sản phẩm</h1>
      <TooltipComponent title="Các sản phẩm thuộc nhóm sản phẩm này." />
    </div>
    <div class="mt-1">
      <a-input
        @click="state.open = true"
        placeholder="Tìm kiếm theo tên sản phẩm"
        size="large"
        readonly
      >
        <template #prefix>
          <i class="far fa-search pr-1 text-gray-500"></i>
        </template>
      </a-input>
      <a-row :gutter="[16, 10]" class="mt-5">
        <a-col
          span="24"
          class="rounded-lg py-2 hover:bg-slate-50"
          v-for="(item, index) in state.productVariants"
          :key="item.id"
        >
          <div class="flex items-center justify-between px-3">
            <div class="flex items-center">
              <span class="mr-2 font-bold">#{{ index + 1 }}</span>
              <div class="rounded border p-1">
                <img class="h-[50px] w-[50px] object-cover" :src="item.image" />
              </div>
              <span class="ml-2">{{ item.name }}</span>
            </div>
            <a-button @click="handleDeleteRow(item.id)" type="primary" danger class="ml-2">
              <i class="fas fa-trash-alt"></i>
            </a-button>
          </div>
        </a-col>
      </a-row>

      <!-- Modal -->
      <a-modal
        v-model:open="state.open"
        width="1000px"
        title="Nhập tìm kiếm sản phẩm"
        @ok="handleOk"
      >
        <a-input
          v-model:value="state.search"
          @change="handleSearch"
          placeholder="Tìm kiếm theo tên sản phẩm"
          size="large"
        >
          <template #prefix>
            <i class="far fa-search pr-1 text-gray-500"></i>
          </template>
        </a-input>
        <div class="mt-5 border-t pt-5">
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
              <template v-if="column.dataIndex === 'name'">
                <div class="flex items-center">
                  <div class="rounded border p-1">
                    <img
                      class="h-[50px] w-[50px] object-cover"
                      :src="record.image"
                      :alt="record.name"
                    />
                  </div>
                  <span class="ml-2">{{ record.name }}</span>
                </div>
              </template>
            </template>
          </a-table>
        </div>
      </a-modal>
    </div>
  </a-card>
</template>
<script setup>
import { TooltipComponent } from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { debounce } from '@/utils/helpers';
import { useField } from 'vee-validate';
import { reactive, watch } from 'vue';

// STATE
const state = reactive({
  endpoint: 'products/variants',
  isShowToolbox: false,
  filterOptions: {},
  dataSource: [],
  open: false,
  search: '',
  productVariantIds: [],
  productVariants: []
});

const columns = [
  {
    title: 'Sản phẩm',
    dataIndex: 'name',
    key: 'name'
  },
  {
    title: 'Giá bán',
    dataIndex: 'price',
    key: 'price',
    sorter: (a, b) => a.price.localeCompare(b.price)
  },
  {
    title: 'Giá khuyến mãi',
    dataIndex: 'sale_price',
    key: 'sale_price',
    sorter: (a, b) => a.sale_price.localeCompare(b.sale_price)
  }
];

const { getAll, loading } = useCRUD();

// Pagination
const {
  pagination,
  rowSelection,
  onChangePagination,
  selectedRowKeys,
  selectedRows,
  handleTableChange
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

const debounceHandleSearch = debounce(() => {
  state.filterOptions = {
    search: state.search
  };
  fetchData();
}, 100);

const handleSearch = () => {
  debounceHandleSearch();
};

const { value } = useField('upsell_ids');

const handleOk = () => {
  const newSelectedIds = Array.isArray(selectedRowKeys.value) ? selectedRowKeys.value : [];
  state.productVariantIds = [...new Set([...state.productVariantIds, ...newSelectedIds])];

  const newVariants = selectedRows.value.filter(
    (item) =>
      newSelectedIds.includes(item.id) && !state.productVariants.some((v) => v.id === item.id)
  );

  state.productVariants = [...state.productVariants, ...newVariants];
  value.value = state.productVariantIds;
  state.open = false;
};

const handleDeleteRow = (id) => {
  state.productVariants = state.productVariants.filter((variant) => variant.id !== id);
  state.productVariantIds = state.productVariantIds.filter((variantId) => variantId !== id);
};
</script>
