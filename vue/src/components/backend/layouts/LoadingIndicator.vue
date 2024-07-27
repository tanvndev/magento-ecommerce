<!-- LoadingIndicator.vue -->
<template>
  <div class="loading-overlay">
    <a-spin size="large" />
  </div>
</template>

<script setup></script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}
</style>
