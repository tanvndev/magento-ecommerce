<template>
  <div class="w-full bg-white">
    <div class="flex items-center justify-between">
      <label :for="props.name" :class="props.labelClass"
        >{{ props.label }}
        <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
      </label>

      <div v-if="props.showAI">
        <a href="#" class="text-blue-500" @click.prevent="openModalAI = true">
          <i class="fas fa-robot mr-1"></i>
          <span> Tạo nội dung với AI </span>
        </a>
      </div>
    </div>

    <QuillEditor
      :name="props.name"
      :id="props.name"
      v-model:content="value"
      theme="snow"
      contentType="html"
      toolbar="full"
    />
    <span v-if="errorMessage" class="mt-[6px] block text-[12px] text-red-500">{{
      errorMessage
    }}</span>
  </div>

  <a-modal v-model:open="openModalAI" title="Tạo nội dung với AI" width="1000px" style="top: 20px">
    <div class="py-5">
      <a-textarea
        v-model:value="prompt"
        size="large"
        placeholder="Tạo cho tôi nội dung cho tiêu đề iPhone 16 promax chuẩn SEO"
        @pressEnter="handleGenerateAI"
        allowClear
        :autosize="{ minRows: 2, maxRows: 10 }"
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
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { message } from 'ant-design-vue';
import axios from 'axios';
import { marked } from 'marked';
import { useField } from 'vee-validate';
import { ref } from 'vue';

const props = defineProps({
  required: {
    type: [Boolean, String],
    default: false
  },
  label: {
    type: String,
    required: true
  },
  labelClass: {
    type: String,
    default: 'mb-2 block text-sm font-medium text-gray-900'
  },
  name: {
    type: String,
    required: true
  },
  placeholder: {
    type: String,
    default: ''
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

value.value = `
`;
const handleGenerateAI = async () => {
  console.log(prompt.value);
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
  value.value = streamingContent.value
    .replace(/\n/g, ' ') // Thay thế dấu xuống dòng bằng khoảng trắng
    .replace(/\s+/g, ' ') // Thay thế nhiều khoảng trắng liên tiếp bằng một khoảng trắng
    .replace(/>\s+</g, '><')
    .trim(); // Loại bỏ khoảng trắng ở đầu và cuối
  console.log(value.value);

  openModalAI.value = false;
};
</script>

<style scoped>
.ql-editor {
  min-height: 200px;
  height: 500px;
}
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
