<template>
  <div>
    <div class="flex items-center justify-between">
      <div>
        <label class="text-[15px] font-bold text-gray-700">
          Tình trạng thuế
          <TooltipComponent color="#108ee9" title="Thay đổi trạng thái cho sản phẩm" />
        </label>
        <span class="block text-[13px] text-gray-500">Áp dụng thuế</span>
      </div>
      <div>
        <SwitchComponent name="is_taxable" @onChange="toggleTax" />
      </div>
    </div>
    <div class="mr-3 mt-5 w-full">
      <SelectComponent
        v-if="isTax"
        className="w-full"
        name="tax"
        :options="TAXT_STATUS"
        placeholder="Chọn tình trạng thuế"
      />
    </div>
    <div class="mr-3 mt-5 w-full border-t border-dashed border-primary-200 px-3 pb-3 pt-5">
      <SelectComponent
        label="Thuế đầu vào"
        className="w-full mb-3"
        name="tax"
        :options="TAXT_STATUS"
        placeholder="Chọn thuế đầu vào"
      />

      <SelectComponent
        label="Thuế đầu ra"
        className="w-full "
        name="tax"
        :options="TAXT_STATUS"
        placeholder="Chọn thuế đầu ra"
      />
    </div>
  </div>
</template>

<script setup>
import { SelectComponent, TooltipComponent, SwitchComponent } from '@/components/backend';
import { TAXT_STATUS } from '@/static/constants';
import { ref } from 'vue';

const isTax = ref(true);

const toggleTax = (value) => {
  isTax.value = value;
};
</script>
