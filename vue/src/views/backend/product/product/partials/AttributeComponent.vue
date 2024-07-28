<template>
  <a-row :gutter="[16, 10]" class="items-center">
    <a-col span="4" class="text-center">
      <label class="font-bold text-red-500">Lưu ý (*)</label>
      <small class="block">(Vui lòng chọn thuộc tính trước khi tạo biến thể.)</small>
    </a-col>
    <a-col span="20">
      <SelectComponent
        name="attribute_catalogue_id"
        label="Nhóm thuộc tính"
        placeholder="Chọn nhóm thuộc tính"
        :options="attributeCatalogueOptions"
        mode="multiple"
        @onChange="handleSelectedAttributeCatalogue"
      />
    </a-col>
    <a-col span="24" class="mt-3 border-t pt-4" v-if="attributes.length">
      <div class="mb-4 flex items-center" v-for="(attribute, index) in attributes" :key="index">
        <div class="w-32">
          <span class="block text-gray-500">Tên:</span>
          <span class="font-bold">{{ attribute.name }}</span>
        </div>
        <div class="w-full">
          <SelectComponent
            :name="`attributes[${attribute.id}]`"
            :placeholder="`Chọn thuộc tính của nhóm ${attribute.name}`"
            :options="formatDataToSelect(attribute.attributes)"
            mode="multiple"
          />
        </div>
      </div>

      <a-space class="mt-1 w-full border-t pt-3">
        <a-button @click="saveAttributes">Lưu thuộc tính</a-button>
      </a-space>
    </a-col>
  </a-row>
</template>

<script setup>
import { useForm } from 'vee-validate';
import { onMounted, ref } from 'vue';
import { SelectComponent } from '@/components/backend';
import { useStore } from 'vuex';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';
import _ from 'lodash';

const store = useStore();
const { getAll, data } = useCRUD();
const { handleSubmit } = useForm();

const attributeCatalogueOptions = ref([]);
const attributeCatalogues = ref([]);
const attributes = ref([]);

// XU LY VA LUU THUOC TINH VAO STORE
const saveAttributes = handleSubmit(async (values) => {
  // reset attribute
  store.commit('productStore/setAttributes', []);

  const attributeIds = values.attributes;
  const dataAttributes = {
    attrIds: [],
    texts: {}
  };

  // Tao ra Map de duyet qua tim ten nhanh hon
  const catalogueMap = new Map(
    attributeCatalogues.value.map((catalogue) => [catalogue.id, catalogue])
  );

  for (const [catalogueId, ids] of Object.entries(attributeIds)) {
    const catalogue = catalogueMap.get(Number(catalogueId));
    if (!catalogue) continue;

    const catalogueName = catalogue.name;
    const attributes = catalogue.attributes;

    if (!ids || _.isEmpty(ids)) {
      return store.dispatch('antStore/showMessage', {
        type: 'error',
        message: 'Vui lòng chọn thuộc tính sản phẩm cho ' + catalogueName
      });
    }

    // Filter and map attributes
    const attributeNames = attributes
      .filter((attribute) => ids.includes(attribute.id))
      .map((attribute) => attribute.name);

    if (!_.isEmpty(attributeNames)) {
      dataAttributes.attrIds[catalogueId] = ids;
      dataAttributes.texts[catalogueName] = attributeNames;
    }
  }

  // Save attributes
  store.commit('productStore/setAttributes', dataAttributes);

  store.dispatch('antStore/showMessage', {
    type: 'success',
    message: 'Lưu thuộc tính thành công.'
  });
});

// XU LY NHOM THUOC TINH
const handleSelectedAttributeCatalogue = (attributeCatalogueIds) => {
  attributes.value = attributeCatalogueIds.map((id) => getAttributesByCatalogue(id));
};

// LAY RA THUOC TINH THEO NHOM THUOC TINH
const getAttributesByCatalogue = (catalogueId) => {
  return attributeCatalogues.value.find((item) => item.id === catalogueId);
};

// LAY RA TAT CA CAC NHOM THUOC TINH
const getAttributeCatalogues = async () => {
  await getAll('attributes/catalogues');
  attributeCatalogueOptions.value = formatDataToSelect(data.value);
  attributeCatalogues.value = data.value;
};

onMounted(() => {
  getAttributeCatalogues();
});
</script>
