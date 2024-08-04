<template>
  <SelectComponent
    name="upsell_ids"
    label="Upsell sản phẩm"
    placeholder="Hãy chọn sản phẩm bạn muốn"
    tooltip-text="Bán thêm là các sản phẩm mà bạn gợi ý khách hàng mua thay vì các sản phẩm họ đang xem, ví dụ, sản phẩm có lợi nhuận cao hơn hoặc tốt hơn hoặc đắt hơn."
  />
</template>
<script setup>
import { SelectComponent } from '@/components/backend';
</script>
