<template>
  <div class="w-full bg-white">
    <label :for="props.name" :class="props.labelClass"
      >{{ props.label }}
      <span v-if="props.required" class="font-semibold text-red-500">(*)</span>
    </label>
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
</template>

<script setup>
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { useField } from 'vee-validate';

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
  }
});

// Tạo field với VeeValidate
const { value, errorMessage } = useField(props.name);
</script>

<style scoped>
.ql-editor {
  min-height: 200px;
  height: 500px;
}
</style>
