<template>
  <a-card class="mt-3" title="Kho hàng">
    <a-row :gutter="[16, 16]" v-if="state.isConfigWarehouse">
      <a-col :span="12">
        <InputNumberComponent
          label="Số dãy"
          :required="true"
          name="aisles_number"
          placeholder="Số dãy"
          tooltip-text="Số dãy được đánh từ A -> Z"
        />
      </a-col>
      <a-col :span="12">
        <InputNumberComponent
          label="Số kệ"
          :required="true"
          name="racks_number"
          placeholder="Số kệ"
          tooltip-text="Số dãy được đánh từ 1 -> n"
        />
      </a-col>
      <a-col :span="12">
        <InputNumberComponent
          label="Số tầng"
          :required="true"
          name="shelves_number"
          placeholder="Số tầng"
          tooltip-text="Số tầng được đánh từ 1 -> n"
        />
      </a-col>

      <a-col :span="12">
        <InputNumberComponent
          label="Số khoang"
          :required="true"
          name="compartments_number"
          placeholder="Số khoang"
          tooltip-text="Số khoang được đánh từ 1 -> n"
        />
      </a-col>
    </a-row>
    <a-row class="mt-3">
      <a-col :span="24">
        <SelectComponent
          label="Cấu hình kho có sẵn"
          :options="WAREHOUSE_CONFIG"
          name="warehouse_configurations"
          placeholder="Chọn mẫu kho có sẵn"
          tooltip-text="Nếu bạn chọn mẫu kho bạn sẽ không thể tự động tạo kho bằng tay như trên"
          @on-change="handleChangeConfigWarehouse"
        />
      </a-col>
    </a-row>
  </a-card>
</template>
<script setup>
import { WAREHOUSE_CONFIG } from '@/static/constants';
import { InputNumberComponent, SelectComponent } from '@/components/backend';
import { reactive } from 'vue';

const emits = defineEmits(['onChangeConfigWarehouse']);
const state = reactive({
  isConfigWarehouse: true
});

const handleChangeConfigWarehouse = (value) => {
  state.isConfigWarehouse = !value ? true : false;

  emits('onChangeConfigWarehouse', state.isConfigWarehouse);
};
</script>
