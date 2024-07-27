<template>
  <div
    class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-gray-800 dark:text-red-400"
    role="alert"
    v-if="Object.keys(props.errors).length"
  >
    <span class="mb-1 block last:mb-0" v-for="error in props.errors" :key="error">{{ error }}</span>
  </div>
</template>
<script setup>
const props = defineProps({
  errors: { Object }
});
</script>
