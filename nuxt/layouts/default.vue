<template>
  <div class="home">
    <div class="page-wrapper">
      <h1 class="d-none">Wolmart - Responsive Marketplace HTML Template</h1>
      <AppHeader />

      <main class="main" style="min-height: 100vh">
        <slot />
      </main>

      <AppFooter />
    </div>
  </div>
</template>

<script setup>
import AppFooter from '~/components/includes/AppFooter.vue'
import AppHeader from '~/components/includes/AppHeader.vue'
</script>
