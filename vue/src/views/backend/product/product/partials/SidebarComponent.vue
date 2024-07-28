<template>
  <a-col :span="7">
    <a-card class="mt-3" title="Ảnh sản phẩm">
      <InputFinderComponent name="image" />
    </a-card>

    <a-card class="mt-3" title="Thương hiệu">
      <SelectComponent
        name="brand_id"
        :options="state.brands"
        placeholder="Chọn thương hiệu sản phẩm"
      />
    </a-card>

    <a-card class="mt-3" title="Danh mục sản phẩm">
      <TreeSelectComponent
        name="parent_id"
        :treeDefaultExpandAll="false"
        :options="state.productCatalogues"
        placeholder="Chọn danh mục sản phẩm"
      />
    </a-card>
    <a-card class="mt-3" title="Nhà cung cấp">
      <SelectComponent
        name="supplier_id"
        :options="state.suppliers"
        placeholder="Chọn nhà cung cấp sản phẩm"
      />
    </a-card>

    <a-card class="mt-3" title="Thông tin bổ sung">
      <div class="mb-4 flex items-center justify-between border-b pb-4">
        <div>
          <label class="text-[15px] font-bold text-gray-700">
            Trạng thái
            <TooltipComponent color="#108ee9" title="Thay đổi trạng thái bán cho sản phẩm" />
          </label>
          <span class="block text-[13px] text-gray-500">Cho phép bán</span>
        </div>
        <div>
          <SwitchComponent name="allow_sell" />
        </div>
      </div>

      <!-- TAX COMPONENT -->
      <TaxComponent />
    </a-card>
  </a-col>
</template>
<script setup>
import {
  SelectComponent,
  InputFinderComponent,
  TreeSelectComponent,
  TooltipComponent,
  SwitchComponent
} from '@/components/backend';
import { useCRUD } from '@/composables';
import { formatDataToTreeSelect, formatDataToSelect } from '@/utils/format';
import { onMounted, reactive } from 'vue';
import TaxComponent from './TaxComponent.vue';

const { getAll, data } = useCRUD();

// STATE
const state = reactive({
  productCatalogues: [],
  brands: [],
  suppliers: []
});

// LAY RA TOAN BO PRODUCT CATALOGUE
const getProductCatalogues = async () => {
  await getAll('products/catalogues');
  state.productCatalogues = formatDataToTreeSelect(data.value);
};

// LAY RA TOAN BO BRAND
const getBrands = async () => {
  await getAll('brands');
  state.brands = formatDataToSelect(data.value);
};

// LAY RA TOAN BO SUPPLIER
const getSuppliers = async () => {
  await getAll('suppliers');
  state.suppliers = formatDataToSelect(data.value, 'id', 'contact_name');
};

onMounted(() => {
  getBrands();
  getSuppliers();
  getProductCatalogues();
});
</script>
