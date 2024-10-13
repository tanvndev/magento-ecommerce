<template>
  <!-- Loading status -->
  <LoadingIndicator v-if="isLoading" />
  <div class="flex h-screen">
    <!-- Sidebar -->
    <SidebarComponent />
    <div class="flex w-full flex-1 flex-col">
      <!-- Header -->
      <HeaderComponent />
      <!-- Main -->
      <main class="h-full overflow-y-auto bg-[#f5f6f7]">
        <slot name="template"></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { SidebarComponent, HeaderComponent, LoadingIndicator } from '@/components/backend';
import { useStore } from 'vuex';
import { useAntToast } from '@/utils/antToast';
import { computed, onMounted, watchEffect } from 'vue';
import { AuthService } from '@/services';

const { showMessage } = useAntToast();
const store = useStore();
const isShowToast = computed(() => store.getters['antStore/getIsShow']);
const isLoading = computed(() => store.getters['loadingStore/getIsLoading']);
const token = computed(() => store.getters['authStore/getToken']);

const setUserCurrent = async () => {
  if (token.value) {
    const user = await AuthService.me();
    store.commit('authStore/setUser', user.data);
  }
};

watchEffect(() => {
  if (isShowToast.value) {
    const type = store.getters['antStore/getType'];
    const message = store.getters['antStore/getMessage'];
    showMessage(type, message);
    store.dispatch('antStore/removeMessage');
  }
});

onMounted(() => {
  setUserCurrent();
});
</script>

<style scoped>
::-webkit-scrollbar {
  width: 5px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #acacac;
  border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
  background: #797979;
}
</style>
