<template>
  <a-card class="mt-3">
    <template #title>
      Tối ưu SEO
      <TooltipComponent
        title="Nếu bạn không nhập thì sẽ tự động lấy 'Tiêu đề', 'Mô tả ngắn sản phẩm' để SEO "
      />
    </template>
    <div v-if="metaTitle || metaDescription">
      <h2 class="text-[16px]">Xem trước kết quả tìm kiếm</h2>

      <div class="mb-4 rounded bg-gray-50 px-4 py-3 pb-3 shadow">
        <h2 class="mb-[2px] text-[16px] text-primary-500">{{ metaTitle }}</h2>
        <p class="mb-[2px] text-green-500 underline underline-offset-2">
          {{ baseUrl + canonical }}
        </p>
        <p class="mb-0 text-gray-500">{{ metaDescription }}</p>
      </div>
    </div>

    <a-row>
      <a-col span="24" class="mb-4">
        <label class="mb-2 block text-sm font-medium text-gray-900">Tiêu đề trang</label>
        <a-input
          v-model:value="metaTitle"
          placeholder="Tiêu đề trang"
          size="large"
          show-count
          :maxlength="60"
        />
      </a-col>
      <a-col span="24">
        <label class="mb-2 block text-sm font-medium text-gray-900">Thẻ mô tả</label>
        <a-textarea
          v-model:value="metaDescription"
          placeholder="Thẻ mô tả"
          size="large"
          show-count
          :maxlength="160"
        />
      </a-col>
      <a-col span="24" class="mb-4">
        <label class="mb-2 block text-sm font-medium text-gray-900">Đường dẫn</label>
        <a-input
          :addon-before="baseUrl"
          placeholder="Đường dẫn"
          v-model:value="canonical"
          size="large"
        />
      </a-col>
    </a-row>
  </a-card>
</template>

<script setup>
import { computed } from 'vue';
import { useField } from 'vee-validate';
import { generateSlug } from '@/utils/helpers';
import { watch } from 'vue';
import TooltipComponent from './TooltipComponent.vue';
const baseUrl = import.meta.env.VITE_BASE_URL + '/';


const { value: metaTitle } = useField('meta_title');
const { value: metaDescription } = useField('meta_description');
const { value: canonical } = useField('canonical');

const slug = computed(() => generateSlug(metaTitle.value));

watch(slug, () => {
  canonical.value = slug.value;
});
</script>
