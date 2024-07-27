<template>
  <header class="bg-white py-4 shadow-lg">
    <div class="container mx-auto flex w-[100%] items-center justify-end">
      <ul class="mb-0 flex flex-shrink-0 items-center justify-end space-x-10">
        <li class="relative inline-block text-left">
          <a-dropdown>
            <button class="relative rounded-md align-middle focus:outline-none">
              <i class="fal fa-bell text-[22px] text-emerald-400"></i>
              <span
                class="pulse absolute right-0 top-0 z-10 inline-flex h-5 w-5 -translate-x-1/2 -translate-y-1/2 transform items-center justify-center rounded-full bg-red-500 p-1 text-xs font-medium leading-none text-red-100"
                >5</span
              >
            </button>
            <template #overlay>
              <div class="w-[300px] rounded-lg bg-white shadow-lg md:w-[400px]">
                <div class="px-5">
                  <div class="flex items-center justify-between pb-2">
                    <h2 class="mb-0 text-lg">Thông báo</h2>
                    <a-badge
                      :number-style="{ backgroundColor: '#52c41a' }"
                      :count="'5 Thông báo'"
                    />
                  </div>
                  <ul class="border-t pt-3">
                    <li class="border-b pb-1 pt-1 last:border-b-0">
                      <h4>Bạn nhận được 1 đơn hàng từ hệ thống</h4>
                      <p class="mb-1 text-[13px]">Mã đơn: OR98723982323</p>
                      <p class="mb-1 text-[13px]">Địa chỉ: Dong anh ha noi</p>
                    </li>
                    <li class="border-b pb-1 pt-1 last:border-b-0">
                      <h4>Bạn nhận được 1 đơn hàng từ hệ thống</h4>
                      <p class="mb-1 text-[13px]">Mã đơn: OR98723982323</p>
                      <p class="mb-1 text-[13px]">Địa chỉ: Dong anh ha noi</p>
                    </li>
                    <li class="border-b pb-1 pt-1 last:border-b-0">
                      <h4>Bạn nhận được 1 đơn hàng từ hệ thống</h4>
                      <p class="mb-1 text-[13px]">Mã đơn: OR98723982323</p>
                      <p class="mb-1 text-[13px]">Địa chỉ: Dong anh ha noi</p>
                    </li>
                  </ul>
                </div>
              </div>
            </template>
          </a-dropdown>
        </li>

        <li class="relative inline-block text-left">
          <a-dropdown>
            <div class="flex cursor-pointer items-center gap-x-2">
              <span class="text-sm uppercase text-gray-700 dark:text-gray-400">{{
                user && user.fullname
              }}</span>
              <button
                class="mx-auto h-9 w-9 overflow-hidden rounded-full border-2 bg-emerald-500 font-medium text-white focus:outline-none dark:bg-gray-500"
              >
                <img
                  class="h-full w-full object-cover"
                  :src="
                    (user && resizeImage(user.image, 100, 100)) || 'https://i.ibb.co/WpM5yZZ/9.png'
                  "
                  loading="lazy"
                />
              </button>
            </div>
            <template #overlay>
              <a-menu>
                <a-menu-item>
                  <RouterLink :to="{ name: 'dashboard' }">
                    <i class="far fa-home mr-2"></i>
                    <span>Dashboard</span>
                  </RouterLink>
                </a-menu-item>
                <a-menu-item>
                  <RouterLink :to="{ name: 'user.update', params: { id: user.id } }">
                    <i class="far fa-cog mr-2"></i>
                    <span>Chỉnh sửa hồ sơ</span>
                  </RouterLink>
                </a-menu-item>
                <a-menu-item @click="store.dispatch('authStore/logout')">
                  <i class="far fa-sign-out mr-2"></i>
                  <span>Đăng xuất</span>
                </a-menu-item>
              </a-menu>
            </template>
          </a-dropdown>
        </li>
      </ul>
    </div>
  </header>
</template>

<script setup>
import { useStore } from 'vuex';
import { computed } from 'vue';
import { RouterLink } from 'vue-router';
import { resizeImage } from '@/utils/helpers';

const store = useStore();
const user = computed(() => store.getters['authStore/getUser']);
</script>
