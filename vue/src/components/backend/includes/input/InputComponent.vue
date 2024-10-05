<template>
  <div class="flex items-center justify-between">
    <label v-if="props.label" :for="props.name" :class="props.labelClass"
      >{{ props.label }}
      <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
      <TooltipComponent v-if="props.tooltipText" :title="props.tooltipText" />
    </label>

    <div v-if="props.showGenerate">
      <a href="#" class="text-blue-500" @click.prevent="handleGenerate">Tạo mã tự động</a>
    </div>

    <div v-if="props.showAI">
      <a href="#" class="text-blue-500" @click.prevent="openModalAI = true">
        <i class="fas fa-robot mr-1"></i>
        <span> Tạo nội dung với AI </span>
      </a>
    </div>
  </div>
  <div>
    <!-- INPUT TEXT -->
    <a-input
      v-if="props.typeInput == 'text' && props.type != 'password'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :type="props.type"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :disabled="props.disabled"
    />

    <!-- INPUT PASSWORD -->
    <a-input-password
      v-if="props.typeInput == 'text' && props.type == 'password'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :type="props.type"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :disabled="props.disabled"
    />

    <!-- INPUT TEXTAREA -->
    <a-textarea
      v-if="props.typeInput == 'textarea'"
      v-model:value="value"
      :class="className"
      :id="props.name"
      :type="props.type"
      :placeholder="props.placeholder"
      :status="errorMessage ? 'error' : ''"
      :size="props.size"
      :allowClear="true"
      :auto-size="{ minRows: 2, maxRows: 50 }"
      show-count
      :maxlength="props.maxlength"
      :disabled="props.disabled"
    />

    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>

  <a-modal
    v-if="showAI"
    v-model:open="openModalAI"
    title="Tạo nội dung với AI"
    width="1000px"
    style="top: 20px"
  >
    <div class="py-5">
      <a-textarea
        v-model:value="prompt"
        size="large"
        placeholder="Tạo cho tôi nội dung cho tiêu đề iPhone 16 promax chuẩn SEO"
        @pressEnter="handleGenerateAI"
        allowClear
        :autoSize="{ minRows: 2, maxRows: 10 }"
      />
    </div>

    <div v-if="streamingContent" class="text-generate-wrap">
      <div v-html="streamingContent"></div>
    </div>

    <template #footer>
      <a-button
        @click="
          () => {
            (streamingContent = ''), (prompt = '');
          }
        "
        v-if="streamingContent"
      >
        Làm mới
      </a-button>
      <a-button @click="openModalAI = false" v-else> Hủy bỏ </a-button>

      <a-button
        type="primary"
        :loading="isLoading"
        v-if="streamingContent"
        @click="handleApplyGenerateAI"
      >
        Áp dụng ngay
      </a-button>
      <a-button type="primary" :loading="isLoading" v-else @click="handleGenerateAI">
        Tạo ngay
      </a-button>
    </template>
  </a-modal>
</template>

<script setup>
import { useField } from 'vee-validate';
import { ref, watch } from 'vue';
import { TooltipComponent } from '@/components/backend';
import { generateRandomString } from '@/utils/helpers';
import { message } from 'ant-design-vue';
import axios from 'axios';
import { marked } from 'marked';

const props = defineProps({
  typeInput: {
    type: String,
    default: 'text'
  },
  required: {
    type: [Boolean, String],
    default: false
  },
  label: {
    type: String,
    default: ''
  },
  labelClass: {
    type: String,
    default: 'mb-2 block text-sm font-medium text-gray-900'
  },
  name: {
    type: String,
    required: true
  },
  className: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  placeholder: {
    type: String,
    default: ''
  },
  size: {
    type: String,
    default: 'large'
  },
  maxlength: {
    type: [String, Number, Boolean],
    default: 0
  },
  oldValue: {
    type: [String, Boolean, Number],
    default: ''
  },

  tooltipText: {
    type: String,
    default: ''
  },
  disabled: {
    type: Boolean,
    default: false
  },
  showGenerate: {
    type: Boolean,
    default: false
  },
  showAI: {
    type: Boolean,
    default: false
  }
});

const openModalAI = ref(false);
const isLoading = ref(false);
const prompt = ref('');
const streamingContent = ref('');

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);

// Watch for changes in oldValue and set value accordingly
watch(
  () => props.oldValue,
  (newOldValue) => {
    if (newOldValue && newOldValue !== undefined && newOldValue !== value.value) {
      value.value = newOldValue;
    }
  },
  { immediate: true }
);

const handleGenerate = () => {
  let str = generateRandomString(12);
  str = str.toUpperCase();
  if (props.showGenerate) {
    value.value = str;
  }
};

const handleGenerateAI = async () => {
  const endpoint = import.meta.env.VITE_API_AI_GENERATE_TEXT;

  if (!prompt.value || prompt.value.length == 0 || prompt.value == '') {
    return message.warn('Vui lòng không để trống.');
  }

  try {
    isLoading.value = true;
    streamingContent.value = ''; // Reset content before starting

    const response = await axios.get(`${endpoint}`, {
      params: { prompt: prompt.value }
    });

    const dataLines = response.data.split('\n').filter(Boolean);
    let result = '';

    for (const line of dataLines) {
      try {
        const cleanedLine = line.startsWith('data: ') ? line.slice(6) : line;
        const json = JSON.parse(cleanedLine);

        if (json.response) {
          for (const char of json.response) {
            result += char;
            streamingContent.value = marked(result);
            await delay(10);
          }
        }
      } catch (e) {
        // console.error('Error parsing JSON:', e);
      }
    }
  } catch (error) {
    console.error('Error:', error);
    message.error('Có lỗi xin vui lòng thử lại.');
  } finally {
    isLoading.value = false;
  }
};

const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

const handleApplyGenerateAI = () => {
  value.value = streamingContent.value;
  openModalAI.value = false;
};
</script>

<style scoped>
ol,
ul,
menu {
  /* list-style: none; */
  margin: 0;
  padding: 0;
  margin-left: 30px;
}

.text-generate-wrap {
  position: relative;
  max-height: 755px;
  overflow-y: auto;
  background-color: #f3f5f7;
  border-radius: 10px;
  padding: 20px;
}
</style>
