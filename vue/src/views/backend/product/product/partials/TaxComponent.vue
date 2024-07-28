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
    <div class="mr-3 mt-5 w-full" v-if="isTax">
      <SelectComponent
        className="w-full"
        name="tax_status"
        :options="TAXT_STATUS"
        placeholder="Chọn tình trạng thuế"
        @on-change="getTaxStatus"
      />

      <div
        class="mr-3 mt-5 w-full border-t border-dashed border-primary-200 px-3 pb-3 pt-5"
        v-if="isTaxInOut"
      >
        <SelectComponent
          label="Thuế đầu vào"
          className="w-full mb-3"
          name="tax_in"
          :options="taxes"
          placeholder="Chọn thuế đầu vào"
        />

        <SelectComponent
          label="Thuế đầu ra"
          className="w-full "
          name="tax_out"
          :options="taxes"
          placeholder="Chọn thuế đầu ra"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { SelectComponent, TooltipComponent, SwitchComponent } from '@/components/backend';
import { TAXT_STATUS } from '@/static/constants';
import { onMounted, ref } from 'vue';
import { useCRUD } from '@/composables';
import { formatDataToSelect } from '@/utils/format';

const isTax = ref(false);
const isTaxInOut = ref(false);
const taxes = ref([]);

const { getAll, data } = useCRUD();

const toggleTax = (value) => {
  isTax.value = value;
};

// XU LY NEU CHUA CO THUE MOI THEM THUE
const getTaxStatus = (value) => {
  isTaxInOut.value = value == 2 ? true : false;
};

const getTax = async () => {
  await getAll('taxes');
  taxes.value = formatDataToSelect(data.value);
};

onMounted(getTax);
</script>
