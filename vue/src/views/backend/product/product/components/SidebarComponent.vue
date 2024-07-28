<template>
  <a-col :span="7">
    <a-card class="mt-3" title="Ảnh sản phẩm">
      <InputFinderComponent name="image" />
    </a-card>

    <a-card class="mt-3" title="Thư viện sản phẩm">
      <InputFinderComponent :multipleFile="true" name="album" />
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
  </a-col>
</template>
<script setup>
import { SelectComponent, InputFinderComponent, TreeSelectComponent } from '@/components/backend';
import { useCRUD } from '@/composables';
import { formatDataToTreeSelect, formatDataToSelect } from '@/utils/format';
import { onMounted, ref } from 'vue';

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
