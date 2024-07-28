<template>
  <a-tooltip :color="props.color">
    <template #title>{{ props.title }}</template>
    <div class="ml-1 inline-block cursor-help" :class="props.className">
      <i class="far fa-info-circle text-primary-500"></i>
    </div>
  </a-tooltip>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    default: ''
  },
  className: {
    type: String,
    default: ' '
  },
  color: {
    type: String,
    default: ''
  }
});
</script>
