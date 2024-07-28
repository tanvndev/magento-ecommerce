<template>
  <a-tooltip :color="props.color">
    <template #title>{{ props.title }}</template>
    <div class="cursor-help" :class="props.className">
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
    default: 'inline-block ml-1'
  },
  color: {
    type: String,
    default: ''
  }
});
</script>
