<template>
  <a-col :span="7">
    <a-card class="mt-3" title="Ảnh sản phẩm">
      <InputFinderComponent name="image" />
    </a-card>

    <a-card class="mt-3" title="Thư viện sản phẩm">
      <InputFinderComponent :multipleFile="true" name="album" />
    </a-card>

    <a-card class="mt-3" title="Danh mục sản phẩm">
      <SelectComponent
        name="product_catalogue_id"
        :options="productCatalogues"
        :placeholder="'Chọn danh mục sản phẩm'"
      />
    </a-card>
  </a-col>
</template>
<script setup>
import { SelectComponent, InputFinderComponent } from '@/components/backend';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';
import { onMounted, ref } from 'vue';
const { getAll, data } = useCRUD();

const productCatalogues = ref(null);

const getProductCatalogues = async () => {
  await getAll('products/catalogues');
  productCatalogues.value = formatDataToSelect(data.value);
};

getProductCatalogues();
onMounted(() => {});
</script>
