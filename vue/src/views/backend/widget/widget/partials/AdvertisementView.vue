<template>
  <div class="mt-10 px-3">
    <a-row
      :gutter="[16, 16]"
      v-for="(item, index) in itemCount"
      :key="index"
      class="mb-7 border-b pb-9 last:mb-0 last:border-none"
    >
      <a-col :span="2" class="mt-7">
        <InputFinderComponent :name="`image[][${index}]`" />
      </a-col>

      <a-col :span="21">
        <a-row :gutter="[16, 16]">
          <a-col :span="24">
            <EditorComponent
              :name="`content[][${index}]`"
              label="Nội dung quảng cáo"
              placeholder="Nội dung quảng cáo"
            />
          </a-col>
          <a-col :span="24">
            <InputComponent
              :name="`url[][${index}]`"
              label="URL"
              placeholder="URL"
              tooltip-text="URL đường dẫn bạn muốn chuyển hướng đến khi nhấp vào quảng cáo."
            />
          </a-col>
          <a-col :span="24">
            <InputComponent
              :name="`alt[][${index}]`"
              label="Alt"
              placeholder="Alt"
              tooltip-text="Alt là nội dung sẽ hiện khi ảnh lỗi."
            />
          </a-col>
        </a-row>
      </a-col>
      <a-col :span="1" class="mt-7" v-if="itemCount > 2">
        <a-button @click="handleDeleteRow" type="primary" danger>
          <i class="fas fa-trash-alt"></i>
        </a-button>
      </a-col>
    </a-row>

    <div class="text-center" v-if="itemCount < 4">
      <a-button @click="handleAddRow" type="dashed" class="mt-4" size="large">
        <i class="fas fa-plus"></i>
        <span class="ml-2">Thêm quảng cáo</span>
      </a-button>
    </div>
  </div>
</template>
<script setup>
import { EditorComponent, InputComponent, InputFinderComponent } from '@/components/backend';
import { ref, watch } from 'vue';

const props = defineProps({
  advertisementBanners: {
    type: [Array, Object],
    default: () => []
  }
});

const itemCount = ref(2);

const handleAddRow = () => {
  itemCount.value++;
};

const handleDeleteRow = () => {
  if (itemCount.value > 2) {
    itemCount.value--;
  }
};

watch(
  () => props.advertisementBanners,
  () => {
    itemCount.value = props.advertisementBanners.length;
  }
);
</script>
