<template>
  <a-card class="my-4">
    <a-breadcrumb class="mb-2">
      <a-breadcrumb-item>
        <RouterLink :to="{ name: 'dashboard' }">
          <i class="fas fa-home-lg-alt mr-2"></i>
          <span>Dashboard</span>
        </RouterLink>
      </a-breadcrumb-item>
      <a-breadcrumb-item>
        <span>
          {{ props.titlePage }}
        </span>
      </a-breadcrumb-item>
    </a-breadcrumb>
    <a-page-header :title="props.titlePage" class="p-0" @back="() => router.back()" />
  </a-card>
</template>
<script setup>
import { RouterLink, useRouter } from 'vue-router';

const props = defineProps({
  titlePage: {
    type: String,
    required: true
  }
});
const router = useRouter();
</script>
