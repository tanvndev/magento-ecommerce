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
          :options="PRODUCT_TYPE"
          :showSearch="false"
          tooltip-text="Sản phẩm đơn giản là sản phẩm có không có phiên bản. Sản phẩm biến thể có nhiều phiên bản khác nhau."
          placeholder="Chọn loại sản phẩm"
          @onChange="handleType"
        />
      </a-col>
      <a-col :span="12">
        <InputComponent name="sku" label="SKU" placeholder="Tự sinh nếu không nhập" />
      </a-col>

      <a-col :span="24" v-if="state.productType">
        <a-tabs v-model:activeKey="state.activeKey" tab-position="top">
          <!-- Chung -->
          <a-tab-pane key="1">
            <template #tab>
              <span>
                <i class="fas fa-wrench mr-1"></i>
                Chung
              </span>
            </template>
            <!-- Chung partials -->
            <CommonPriceComponent />
          </a-tab-pane>
          <!-- Kho hang -->
          <a-tab-pane key="2" v-if="state.productType === 'simple'">
            <template #tab>
              <span>
                <i class="far fa-dolly-flatbed-alt mr-1"></i>
                Kiểm kê kho hàng
              </span>
            </template>
            <!-- Kho hang partials -->
            <InstockComponent :warehouses="state.warehouses" />
          </a-tab-pane>
          <!-- Giao hang -->
          <a-tab-pane key="3">
            <template #tab>
              <span>
                <i class="far fa-shipping-fast mr-1"></i>
                Giao hàng
              </span>
            </template>
            <!-- Giao hang partials -->
            <ShippingComponent />
          </a-tab-pane>
          <!-- Upsell -->
          <a-tab-pane key="4">
            <template #tab>
              <span>
                <i class="fas fa-link mr-1"></i>
                Các sản phẩm được kết nối
              </span>
            </template>
            <UpsellComponent />
          </a-tab-pane>
          <!-- Thuoc tinh -->
          <a-tab-pane key="5" v-if="state.productType === 'variable'">
            <template #tab>
              <span>
                <i class="fas fa-tasks-alt mr-1"></i>
                Các thuộc tính
              </span>
            </template>
            <AttributeComponent />
          </a-tab-pane>
          <!-- Bien the -->
          <a-tab-pane key="6" v-if="state.productType === 'variable'">
            <template #tab>
              <span>
                <i class="far fa-table mr-1"></i>
                Các biến thể
              </span>
            </template>
            <VariantComponent :warehouses="state.warehouses" />
          </a-tab-pane>
        </a-tabs>
      </a-col>
    </a-row>
  </a-card>
</template>

<script setup>
import { SelectComponent, InputComponent } from '@/components/backend';
import AttributeComponent from './AttributeComponent.vue';
import VariantComponent from './VariantComponent.vue';
import CommonPriceComponent from './CommonPriceComponent.vue';
import { onMounted, reactive } from 'vue';
import { useCRUD } from '@/composables';
import InstockComponent from './InstockComponent.vue';
import ShippingComponent from './ShippingComponent.vue';
import UpsellComponent from './UpsellComponent.vue';
import { PRODUCT_TYPE } from '@/static/constants';

const { getAll } = useCRUD();

// STATE
const state = reactive({
  warehouses: [],
  productType: '',
  activeKey: '1'
});

// XU LY KIEU SAN PHAM
const handleType = (value) => {
  state.productType = value;
};

// LAY RA TOAN BO KHO HANG
const getWarehouses = async () => {
  state.warehouses = await getAll('warehouses');
};

onMounted(getWarehouses);
</script>
