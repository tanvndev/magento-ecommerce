<template>
  <a-space class="w-full justify-between" :size="12">
    <a-button
      :loading="state.isLoading"
      :disabled="_.isEmpty(attributes)"
      type="dashed"
      @click="handleCreateVariant"
    >
      <i class="fas fa-layer-plus mr-2"></i>
      Tự động tạo biến thể
    </a-button>
    <span class="text-gray-500" v-if="!_.isEmpty(state.variantTexts)"
      >(Tổng cộng: {{ state.variantTexts.length }} biến thể)
    </span>
  </a-space>

  <!-- Danh sách bien the -->
  <a-row class="mt-5 border-t pt-3" :gutter="[16, 10]" v-if="state.variantTexts.length">
    <!-- Attribute -->
    <a-col
      class="mb-4 border-b pb-5 first:mt-3 last:mb-0 last:border-b-0 last:pb-2"
      span="24"
      v-for="(variantText, i) in state.variantTexts"
      :key="variantText"
    >
      <div class="flex items-center justify-between">
        <a-space>
          <span class="mr-2 font-bold">#{{ i + 1 }}</span>
          <span class="rounded-md bg-[#0000000a] px-4 py-2 font-bold text-primary-700">{{
            variantText
          }}</span>

          <!-- Variant_count -->
          <div class="hidden">
            <InputComponent :name="`variable[count][${i}]`" :old-value="i + ''" />
          </div>
        </a-space>
        <a-space>
          <!-- Edit -->
          <a-button @click="toggerOpenEdit(i)">
            <i class="fas fa-pencil-alt"></i>
          </a-button>
          <!-- Delete -->
          <a-popconfirm
            title="Bạn có chắc chắn muốn xóa?"
            ok-text="Xóa"
            cancel-text="Hủy"
            @confirm="handleDeleteRowVariant(i)"
          >
            <a-button danger>
              <i class="fas fa-trash-alt"></i>
            </a-button>
          </a-popconfirm>
        </a-space>
      </div>

      <!-- EditForm -->
      <a-row class="mt-3 border-t px-3 pt-3" :class="state.openEdit[i] ? 'block' : 'hidden'">
        <a-col span="24" class="mb-4 border-b pb-4">
          <a-row :gutter="[16, 10]" class="items-center">
            <a-col span="3" class="text-center">
              <label class="font-bold">Ảnh</label>
              <small class="block text-gray-500">(Mặc định sẽ lấy ảnh sản phẩm)</small>
            </a-col>
            <a-col span="5">
              <InputFinderComponent :name="`variable[image][${i}]`" />
            </a-col>
            <a-col span="16">
              <InputComponent
                :name="`variable[sku][${i}]`"
                label="SKU"
                placeholder="Tự sinh nếu không nhập"
              />
            </a-col>
          </a-row>
        </a-col>
        <!-- Anh -->
        <a-col span="24" class="mb-4 border-b pb-4">
          <a-row class="items-center" :gutter="[16, 10]">
            <a-col span="3" class="text-center">
              <label class="font-bold">Thư viện ảnh</label>
              <small class="block text-gray-500">(Mặc định sẽ lấy ảnh thư viện sản phẩm)</small>
            </a-col>
            <a-col span="21">
              <InputFinderComponent :name="`variable[album][${i}]`" :multipleFile="true" />
            </a-col>
          </a-row>
        </a-col>
        <!-- Gia -->
        <a-col span="24" class="mb-4 border-b pb-4">
          <a-row class="items-center" :gutter="[16, 20]">
            <a-col span="8">
              <InputNumberComponent
                :name="`variable[price][${i}]`"
                label="Giá bán"
                placeholder="Giá bán"
              />
            </a-col>
            <a-col span="8">
              <InputNumberComponent
                :name="`variable[sale_price][${i}]`"
                label="Giá ưu đãi"
                placeholder="Giá ưu này"
              />
            </a-col>
            <a-col span="8">
              <InputNumberComponent
                :name="`variable[import_price][${i}]`"
                label="Giá nhập"
                placeholder="Giá nhập"
              />
            </a-col>
            <!-- Discount_time -->
            <a-col>
              <SwitchComponent
                :name="`variable[is_discount_time][${i}]`"
                checkText="Lên lịch"
                uncheckText="Hủy lên lịch"
                @onChange="handleDiscountTime($event, i)"
              />
            </a-col>
            <a-col span="24" v-if="state.isDiscountTime[i]">
              <InputDateComponent
                type="date-range"
                :name="`variable[sale_price_time][${i}]`"
                :showTime="true"
              />
            </a-col>
          </a-row>
        </a-col>
        <!-- Giao hang -->
        <a-col span="24" class="mb-4 border-b pb-4">
          <a-row class="items-center" :gutter="[16, 10]">
            <a-col span="6">
              <InputNumberComponent
                :name="`variable[weight][${i}]`"
                label="Cân nặng (kg)"
                placeholder="Cân nặng"
              />
            </a-col>
            <a-col span="6">
              <InputNumberComponent
                :name="`variable[length][${i}]`"
                label="Dài (cm)"
                placeholder="Dài"
              />
            </a-col>
            <a-col span="6">
              <InputNumberComponent
                :name="`variable[width][${i}]`"
                label="Rộng (cm)"
                placeholder="Rộng"
              />
            </a-col>
            <a-col span="6">
              <InputNumberComponent
                :name="`variable[height][${i}]`"
                label="Cao (cm)"
                placeholder="Cao"
              />
            </a-col>
          </a-row>
        </a-col>
        <!-- Kho hang -->
        <a-col span="24" class="mb-4 border-b pb-4" v-if="props.warehouses.length">
          <h3 class="mb-5 text-center text-lg uppercase">Kiểm kê kho hàng</h3>
          <a-row class="items-center" :gutter="[30, 20]">
            <a-col
              span="12"
              v-for="warehouse in props.warehouses"
              :key="`${warehouse.id}_warehouse`"
            >
              <h4 class="mb-2 text-center">{{ warehouse.name }}</h4>
              <a-row :gutter="[10, 10]">
                <a-col span="12">
                  <InputNumberComponent
                    :name="`stock[in_stock][${warehouse.id}][${i}]`"
                    placeholder="Tồn kho"
                  />
                </a-col>
                <a-col span="12">
                  <InputNumberComponent
                    :name="`stock[cog_price][${warehouse.id}][${i}]`"
                    placeholder="Giá vốn"
                  />
                </a-col>
              </a-row>
            </a-col>
          </a-row>
        </a-col>
      </a-row>
    </a-col>
  </a-row>
</template>
<script setup>
import _ from 'lodash';
import { computed, reactive } from 'vue';
import {
  InputNumberComponent,
  SwitchComponent,
  InputComponent,
  InputDateComponent,
  InputFinderComponent
} from '@/components/backend';
import { useStore } from 'vuex';

const props = defineProps({
  warehouses: {
    type: [Array, Object],
    default: () => []
  }
});

const store = useStore();
const attributes = computed(() => store.getters['productStore/getAttributes']);

// STATE
const state = reactive({
  openEdit: {},
  variantTexts: [],
  isLoading: false,
  isDiscountTime: {}
});

// XU LY TAO RA CAC BIEN THE
const handleCreateVariant = () => {
  state.isLoading = true;

  if (_.isEmpty(attributes.value)) {
    return store.dispatch('antStore/showMessage', {
      type: 'error',
      message: 'Vui lòng chọn thuộc tính sản phẩm trước khi tạo biến thể.'
    });
  }

  const variantTextData = combineVariantText(attributes.value.texts);
  store.commit('productStore/setVariants', variantTextData);

  setTimeout(() => {
    state.variantTexts = variantTextData;
  }, 1000);

  setTimeout(() => {
    state.isLoading = false;
  }, 1000);
};

// LAM PHANG MANG VE GHEP CAC BIEN THE
const calculateVariant = (arrays) => {
  if (_.isEmpty(arrays)) return [];

  return arrays.reduce(
    (acc, curr) => {
      return _.flatMap(acc, (a) => _.map(curr, (b) => a.concat(b)));
    },
    [[]]
  );
};

// KET HOP CA BIEN THE VUA TAO
const combineVariantText = (texts) => {
  if (_.isEmpty(texts)) return [];

  // Extract the attribute names and values
  const attributeNames = _.keys(texts);
  const attributeValues = _.values(texts);

  // Generate the Cartesian product of attribute values
  const combinations = calculateVariant(attributeValues);

  // Format each combination into the desired string format
  return combinations.map((combination) => {
    return attributeNames
      .map((name, index) => {
        return `${combination[index]}`;
      })
      .join(' - ');
  });
};

// XU LY XOA CAC HANG BIEN THE
const handleDeleteRowVariant = (index) => {
  state.variantTexts.splice(index, 1);
};

// XU LY CO THOI GIAN CHO GIAM GIA CHO BIEN THE KHONG
const handleDiscountTime = (value, index) => {
  state.isDiscountTime[index] = value;
};

// DONG MO CHUC NANG CHINH SUA THEO HANG
const toggerOpenEdit = (itemId) => {
  state.openEdit[itemId] = !state.openEdit[itemId];
};
</script>
