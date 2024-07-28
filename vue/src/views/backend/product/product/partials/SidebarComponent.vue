<template>
  <a-col :span="7">
    <a-card class="mt-3" title="Ảnh sản phẩm">
      <InputFinderComponent name="image" />
    </a-card>

    <a-card class="mt-3" title="Thương hiệu">
      <SelectComponent name="brand_id" :options="brands" placeholder="Chọn thương hiệu sản phẩm" />
    </a-card>

    <a-card class="mt-3" title="Danh mục sản phẩm">
      <TreeSelectComponent
        name="parent_id"
        :treeDefaultExpandAll="false"
        :options="productCatalogues"
        placeholder="Chọn danh mục sản phẩm"
      />
    </a-card>
    <a-card class="mt-3" title="Nhà cung cấp">
      <SelectComponent
        name="supplier_id"
        :options="suppliers"
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
          <SwitchComponent name="publish" />
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
import { onMounted, ref } from 'vue';
import TaxComponent from './TaxComponent.vue';

const { getAll, data } = useCRUD();

const productCatalogues = ref(null);
const brands = ref(null);
const suppliers = ref(null);

const getProductCatalogues = async () => {
  await getAll('products/catalogues');
  productCatalogues.value = formatDataToTreeSelect(data.value);
};

const getBrands = async () => {
  await getAll('brands');
  brands.value = formatDataToSelect(data.value);
};

const getSuppliers = async () => {
  await getAll('suppliers');
  suppliers.value = formatDataToSelect(data.value, 'id', 'contact_name');
};

onMounted(() => {
  getBrands();
  getSuppliers();
  getProductCatalogues();
});
</script>
