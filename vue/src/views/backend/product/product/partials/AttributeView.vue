<template>
  <a-row :gutter="[16, 10]" class="items-center">
    <a-col span="4" class="text-center" v-if="props.productType == 'variable'">
      <label class="font-bold text-red-500">Lưu ý (*)</label>
      <small class="block">(Vui lòng chọn thuộc tính trước khi tạo biến thể.)</small>
    </a-col>
    <a-col :span="props.productType == 'variable' ? 20 : 24">
      <SelectComponent
        name="attribute_id"
        label="Thuộc tính"
        placeholder="Chọn thuộc tính"
        :options="state.attributeOptions"
        mode="multiple"
        @onChange="handleSelectedAttribute"
      />
    </a-col>

    <a-divider v-if="state.attributeValues.length"
      >Chọn Giá Trị Cho Thuộc Tính
      <TooltipComponent
        v-if="props.productType == 'variable'"
        title="Nếu bạn chọn 'Nhận' thì thuộc tính đó sẽ được chọn làm biến thể còn nếu bạn 'Hủy' thì sẽ không được chọn làm biến thể. Và bạn chỉ được nhận tôi đa 3 thuộc tính làm biến thể."
      />
    </a-divider>
    <!-- Value -->
    <a-col span="24" v-if="state.attributeValues.length">
      <div
        class="mb-4 flex items-center"
        v-for="(attributeValue, index) in state.attributeValues"
        :key="index"
      >
        <div class="mr-2 w-32">
          <span class="block text-gray-500">Tên:</span>
          <span class="font-bold">{{ attributeValue.name }}</span>
        </div>

        <div class="w-full">
          <SelectComponent
            :name="`attribute_value_ids[${attributeValue.id}]`"
            :placeholder="`Chọn giá trị thuộc tính của thuộc tính ${attributeValue.name}`"
            :options="formatDataToSelect(attributeValue.values)"
            mode="multiple"
          />
        </div>

        <div class="ml-3" v-if="props.productType == 'variable'">
          <SwitchComponent
            :name="`enable_variation[${attributeValue.id}]`"
            checkText="Nhận"
            uncheckText="Hủy"
            :disabled="exceedsVariationLimit && !state.enableVariation[attributeValue.id]"
            @onChange="handleEnableVariation($event, attributeValue.id)"
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
import { computed, onMounted, reactive } from 'vue';
import { SelectComponent, SwitchComponent, TooltipComponent } from '@/components/backend';
import { useStore } from 'vuex';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';
import _ from 'lodash';
import { message } from 'ant-design-vue';

const store = useStore();
const { getAll, data } = useCRUD();
const { handleSubmit } = useForm();

const props = defineProps({
  productType: {
    type: String,
    default: ''
  }
});

// STATE
const state = reactive({
  attributeOptions: [],
  attributes: [],
  attributeValues: [],
  enableVariation: {}
});

const exceedsVariationLimit = computed(() => {
  // Check if the number of enabled variations exceeds the limit
  return Object.values(state.enableVariation).filter(Boolean).length >= 3;
});

// XU LY VA LUU THUOC TINH VAO STORE
const saveAttributes = handleSubmit(async (values) => {
  if (Object.values(state.enableVariation).filter(Boolean).length > 3) {
    return message.error('Bạn chỉ được chọn tối đa 3 thuộc tính làm biến thể.');
  }

  store.commit('productStore/setAttributes', []);
  const attributeIds = values.attribute_value_ids;

  const dataAttributes = {
    enable_variation: values?.enable_variation,
    attrIds: [],
    texts: {}
  };

  // Tao ra Map de duyet qua tim ten nhanh hon
  const attributeMap = new Map(state.attributes.map((attribute) => [attribute.id, attribute]));

  for (const [attributeId, valueIds] of Object.entries(attributeIds)) {
    const attribute = attributeMap.get(Number(attributeId));
    if (!attribute) continue;

    const attributeName = attribute.name;
    const attrValues = attribute.values;

    if (!valueIds || _.isEmpty(valueIds)) {
      return store.dispatch('antStore/showMessage', {
        type: 'error',
        message: 'Vui lòng chọn giá trị cho ' + attributeName
      });
    }

    // Filter and map attributes
    const attributeNames = attrValues
      .filter((attrValue) => valueIds.includes(attrValue.id))
      .map((attrValue) => {
        return [attrValue.id, attrValue.name];
      });

    if (!_.isEmpty(attributeNames)) {
      dataAttributes.attrIds[attributeId] = valueIds;

      // If enable variation is true
      if (dataAttributes.enable_variation && dataAttributes.enable_variation[attributeId] == true) {
        dataAttributes.texts[attributeName] = attributeNames;
      }
    }
  }

  // Save attributes
  store.commit('productStore/setAttributes', dataAttributes);
  message.success('Lưu thuộc tính thành công.');
});

const handleEnableVariation = (checked, attributeId) => {
  if (checked && exceedsVariationLimit.value) {
    message.warning('Bạn chỉ được chọn tối đa 3 thuộc tính làm biến thể.');
    // Reset the switch if limit exceeded
    state.enableVariation[attributeId] = false;
  } else {
    state.enableVariation[attributeId] = checked;
  }
};

const handleSelectedAttribute = (attributeIds) => {
  state.attributeValues = attributeIds.map((id) => state.attributes.find((item) => item.id === id));
};

// LAY RA TAT CA CAC NHOM THUOC TINH
const getAttributes = async () => {
  await getAll('attributes');
  state.attributeOptions = formatDataToSelect(data.value);
  state.attributes = data.value;
};

onMounted(() => {
  getAttributes();
});
</script>
