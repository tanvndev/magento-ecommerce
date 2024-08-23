<template>
    <a-row :gutter="[16, 16]" class="items-center">
        <a-col span="6">
            <div class="flex items-center gap-5">
                <label class="font-bold">Quản lý kho hàng</label>
                <SwitchComponent @on-change="handleEnableManageStock" name="enable_manage_stock" check-text="Đồng ý" uncheck-text="Hủy bỏ"
                    tooltip-text="Các thiết lập bên dưới áp dụng cho tất cả các biến thể mà không bật chức năng quản lý kho thủ công." />
            </div>
        </a-col>
        <a-col span="18" v-if="state.stockStatus === 'outofstock'">
            <SelectComponent name="stock_status" label="Trạng thái kho hàng" :options="state.stockStatusOptions"
                placeholder="Chọn trạng thái kho hàng" />
        </a-col>

        <a-col span="18" v-if="state.stockStatus === 'instock'">
            <InputNumberComponent name="quantity" label="Số lượng" placeholder="Nhập số lượng" />
        </a-col>
    </a-row>
</template>
<script setup>
import { SelectComponent, SwitchComponent, InputNumberComponent } from '@/components/backend';
import { STOCK_STATUS } from '@/static/constants';
import { reactive } from 'vue';
const state = reactive({
    stockStatusOptions: STOCK_STATUS,
    stockStatus: 'outofstock',
})

const handleEnableManageStock = (value) => {
    state.stockStatus = value ? 'instock' : 'outofstock';
}
</script>
