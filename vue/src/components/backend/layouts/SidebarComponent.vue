<template>
  <aside
    class="z-30 hidden w-64 flex-shrink-0 overflow-y-auto bg-white shadow-lg dark:bg-gray-800 lg:block"
  >
    <div class="py-4 text-gray-500">
      <RouterLink :to="{ name: 'dashboard' }" class="flex items-center justify-center"
        ><img
          class="w-[120px] object-contain object-center"
          src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjsScWYmyfPv3XdkNdEFVJ1wlDKMOgcSWUcg&s"
          alt="logo"
      /></RouterLink>

      <ul>
        <li
          v-for="item in sidebar"
          :key="item.name"
          :class="{
            active: isActive(item),
            'px-6 py-4': item.subMenu.length > 0,
            relative: true
          }"
        >
          <button
            type="button"
            class="block w-full text-left text-sm"
            @click="toggerDropdown(item.id)"
            v-if="item.subMenu.length > 0"
          >
            <div
              class="link-item inline-flex w-full items-center text-[15px] transition-colors duration-150 hover:text-emerald-600"
            >
              <span
                class="line-left absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-emerald-500"
                aria-hidden="true"
              ></span>
              <div class="flex w-full items-center justify-between">
                <div>
                  <i :class="`${item.icon} mr-3`"></i>
                  <span class="font-bold capitalize"> {{ item.name }} </span>
                </div>
                <div>
                  <i
                    :class="[
                      'mr-1 text-[10px]',
                      openDropdowns[item.id] ? 'far fa-chevron-down' : 'far fa-chevron-right'
                    ]"
                  ></i>
                </div>
              </div>
            </div>
          </button>

          <div class="block px-6 py-4 text-sm" v-else>
            <RouterLink
              :to="{ name: item.route }"
              class="link-item inline-flex items-center text-[15px] transition-colors duration-150 hover:text-emerald-600"
            >
              <span
                class="line-left absolute inset-y-0 left-0 w-1 rounded-br-lg rounded-tr-lg bg-emerald-500"
                aria-hidden="true"
              ></span>
              <i :class="`${item.icon} mr-3`"></i>
              <span class="font-bold capitalize"> {{ item.name }} </span>
            </RouterLink>
          </div>

          <ul
            class="bg-gray-00 mt-2 overflow-hidden rounded-md p-2 text-sm font-medium transition-all duration-150 dark:bg-gray-900"
            v-if="item.subMenu.length > 0 && openDropdowns[item.id]"
          >
            <li class="mb-1" v-for="itemSub in item.subMenu" :key="itemSub.route">
              <RouterLink
                class="sub-link font-serif inline-flex cursor-pointer items-center py-1 text-sm transition-colors duration-150 hover:text-emerald-600"
                :to="{ name: itemSub.route }"
                exactActiveClass="text-[#10b981]"
              >
                <i class="far fa-dot-circle text-[6px]"></i>
                <span class="ml-1">{{ itemSub.name }}</span>
              </RouterLink>
            </li>
          </ul>
        </li>
      </ul>

      <div class="fixed bottom-0 mx-auto mt-3 block w-64 px-6 py-6">
        <button
          class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-transparent bg-emerald-500 px-5 py-3 align-bottom font-medium leading-5 text-white transition-colors duration-150 hover:bg-emerald-600 focus:outline-none active:bg-emerald-600"
          type="button"
        >
          <span class="flex items-center">
            <i class="far fa-sign-out mr-3"></i>
            <span class="text-sm">Đăng xuất</span>
          </span>
        </button>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { ref } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import sidebar from '@/static/sidebar';

const openDropdowns = ref({});
const route = useRoute();

const toggerDropdown = (itemId) => {
  openDropdowns.value[itemId] = !openDropdowns.value[itemId];
};
const isActive = (item) => {
  return route.name == item.route || item.subMenu.some((sub) => route.name === sub.route);
};
</script>

<style scoped>
.line-left {
  display: none;
}
.active .line-left {
  display: block;
}
.active .link-item {
  color: #10b981;
}
</style>
