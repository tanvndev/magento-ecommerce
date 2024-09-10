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
            class="components-table-demo-nested"
          >
            <template #bodyCell="{ column, record }">
              <template v-if="column.dataIndex === 'product_type'">
                {{ getProductTypeLabel(record.product_type) }}
              </template>
              <template v-if="column.dataIndex === 'total_stock'">
                <a-tag :color="record.total_stock_color">{{ record.total_stock }}</a-tag>
              </template>
              <template v-if="column.dataIndex === 'brand_name'">
                <a-tag color="cyan">{{ record.brand_name }}</a-tag>
              </template>
              <template v-if="column.dataIndex === 'name'">
                <RouterLink
                  :to="{ name: 'product.update', params: { id: record.id } }"
                  class="text-blue-500"
                  >{{ record.name }}</RouterLink
                >
              </template>
              <template v-if="column.dataIndex === 'catalogues'">
                <div v-html="renderCatalogues(record.catalogues)"></div>
              </template>
              <template v-if="column.dataIndex === 'publish'">
                <StatusSwitchComponent
                  :record="record"
                  :modelName="state.modelName"
                  :field="column.dataIndex"
                />
              </template>
            </template>

            <template #expandedRowRender="{ record }">
              <a-table :columns="innerColumns" :data-source="record.variants" :pagination="false">
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
                  <template v-if="column.key === 'stock'">
                    <a-tag :color="record.stock_color">{{ record.stock }}</a-tag>
                  </template>

                  <template v-if="column.dataIndex === 'cost_price'">
                    {{ formatCurrency(record.cost_price) }}
                  </template>
                  <template v-if="column.dataIndex === 'price'">
                    {{ formatCurrency(record.price) }}
                  </template>
                  <template v-if="column.dataIndex === 'sale_price'">
                    {{ formatCurrency(record.sale_price) }}
                  </template>

                  <template v-if="column.key === 'shipping'">
                    <ul class="mb-0 list-disc">
                      <li>
                        Cân nặng: <span class="font-bold">{{ record.weight }} g</span>
                      </li>
                      <li>
                        Cao: <span class="font-bold">{{ record.height }} cm</span>
                      </li>
                      <li>
                        Dài: <span class="font-bold">{{ record.length }} cm</span>
                      </li>
                      <li>
                        Rộng: <span class="font-bold">{{ record.width }} cm</span>
                      </li>
                    </ul>
                  </template>
                </template>
              </a-table>
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
import { PRODUCT_TYPE } from '@/static/constants';
import { columns, innerColumns } from './columns';
import {
  BreadcrumbComponent,
  MasterLayout,
  FilterComponent,
  StatusSwitchComponent,
  ToolboxComponent
} from '@/components/backend';
import { useCRUD, usePagination } from '@/composables';
import { RouterLink } from 'vue-router';
import { resizeImage } from '@/utils/helpers';
import { formatCurrency } from '@/utils/format';

// STATE
const state = reactive({
  pageTitle: 'Danh sách sản phẩm',
  modelName: 'Product',
  routeCreate: 'product.store',
  routeUpdate: 'product.update',
  endpoint: 'products',
  isShowToolbox: false,
  modelIds: [],
  filterOptions: {},
  dataSource: []
});

// CRUD Operations
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

// Fetch data
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
watch(onChangePagination, fetchData);
watch(selectedRows, () => {
  state.isShowToolbox = selectedRows.value.length > 0;
  state.modelIds = selectedRowKeys.value;
});

// Event Handlers
const onFilterOptions = (filterValue) => {
  state.filterOptions = filterValue;
  fetchData();
};

const onChangeToolbox = () => {
  fetchData();
};

const getProductTypeLabel = (type) => PRODUCT_TYPE.find((item) => item.value === type)?.label || '';

const renderCatalogues = (catalogues) =>
  catalogues
    .map(
      (catalogue) =>
        `<a href="/product/catalogue/update/${catalogue.id}" style="color: blue; margin-left: 3px">${catalogue.name}</a>`
    )
    .join(',');

// Lifecycle Hook
onMounted(fetchData);
</script>
