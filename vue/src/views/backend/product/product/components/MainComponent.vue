<template>
  <a-card class="mt-3">
    <template #title>
      <span> Dữ liệu sản phẩm </span>
    </template>
    <a-row :gutter="[16, 10]">
      <a-col :span="12">
        <SelectComponent
          name="product_type"
          label="Loại sản phẩm"
          :required="true"
          :options="productTypeData"
          :showSearch="false"
          placeholder="Chọn loại sản phẩm"
          @onChange="handleType"
        />
      </a-col>
      <a-col :span="12">
        <InputComponent name="sku" label="Mã sản phẩm" placeholder="Tự sinh nếu không nhập" />
      </a-col>

      <a-col :span="24" v-if="productType">
        <a-tabs v-model:activeKey="activeKey" tab-position="top">
          <!-- Chung -->
          <a-tab-pane key="1">
            <template #tab>
              <span>
                <i class="fas fa-wrench mr-1"></i>
                Chung
              </span>
            </template>
            <CommonPriceComponent />
          </a-tab-pane>
          <!-- Kho hang -->
          <a-tab-pane key="2">
            <template #tab>
              <span>
                <i class="far fa-dolly-flatbed-alt mr-1"></i>
                Kiểm kê kho hàng
              </span>
            </template>
            <a-row :gutter="[16, 10]">
              <a-col span="12">
                <InputNumberComponent name="stock" label="Số lượng" />
              </a-col>
            </a-row>
          </a-tab-pane>
          <!-- Giao hang -->
          <a-tab-pane key="3">
            <template #tab>
              <span>
                <i class="far fa-shipping-fast mr-1"></i>
                Giao hàng
              </span>
            </template>
            <a-row :gutter="[16, 10]">
              <a-col span="6">
                <InputNumberComponent name="weight" label="Cân nặng (kg)" />
              </a-col>
              <a-col span="6">
                <InputNumberComponent name="length" label="Dài (cm)" />
              </a-col>
              <a-col span="6">
                <InputNumberComponent name="width" label="Rộng (cm)" />
              </a-col>
              <a-col span="6">
                <InputNumberComponent name="hight" label="Cao (cm)" />
              </a-col>
            </a-row>
          </a-tab-pane>
          <!--  -->
          <a-tab-pane key="4">
            <template #tab>
              <span>
                <i class="fas fa-link mr-1"></i>
                Các sản phẩm được kết nối
              </span>
            </template>
            <div>Các sản phẩm được kết nối</div>
          </a-tab-pane>
          <!-- Thuoc tinh -->
          <a-tab-pane key="5" v-if="productType === 'variable'">
            <template #tab>
              <span>
                <i class="fas fa-tasks-alt mr-1"></i>
                Các thuộc tính
              </span>
            </template>
            <AttributeComponent />
          </a-tab-pane>
          <!-- Bien the -->
          <a-tab-pane key="6" v-if="productType === 'variable'">
            <template #tab>
              <span>
                <i class="far fa-table mr-1"></i>
                Các biến thể
              </span>
            </template>
            <VariantComponent />
          </a-tab-pane>
        </a-tabs>
      </a-col>
    </a-row>
  </a-card>
</template>

<script setup>
import { SelectComponent, InputNumberComponent, InputComponent } from '@/components/backend';
import AttributeComponent from './AttributeComponent.vue';
import VariantComponent from './VariantComponent.vue';
import CommonPriceComponent from './CommonPriceComponent.vue';
import { computed, onMounted, ref } from 'vue';
import { useStore } from 'vuex';
import { useCRUD } from '@/composables';

const { getAll, data } = useCRUD();
const store = useStore();
const productTypeData = computed(() => store.getters['languageStore/getProductType']);

const activeKey = ref('6');
const productType = ref('variable');

const handleType = (value) => {
  console.log(value);
  productType.value = value;
};
</script>
