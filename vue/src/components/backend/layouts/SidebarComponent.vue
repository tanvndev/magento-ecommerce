<template>
    <aside class="z-30 hidden w-64 flex-shrink-0 overflow-y-auto bg-white shadow-lg dark:bg-gray-800 lg:block">
        <div class="py-4 text-gray-500">
            <RouterLink :to="{ name: 'dashboard' }" class="flex items-center justify-center"><img
                    class="w-[120px] object-contain object-center"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjsScWYmyfPv3XdkNdEFVJ1wlDKMOgcSWUcg&s"
                    alt="logo" /></RouterLink>

            <a-menu v-model:selectedKeys="selectedKeys" v-model:openKeys="openKeys" mode="inline">
                <a-menu-item v-for="item in menuItems" :key="item.route">
                    <RouterLink class="inline-flex cursor-pointer items-center" :to="{ name: item.route }">
                        <i :class="item.icon" class="mr-3"></i>
                        <span class="ml-1">{{ item.name }}</span>
                    </RouterLink>
                </a-menu-item>

                <a-sub-menu v-for="item in subMenuItems" :key="item.id">
                    <template #title>
                        <span>
                            <i :class="item.icon" class="mr-3"></i>
                            <span class="capitalize">{{ item.name }}</span>
                        </span>
                    </template>
                    <a-menu-item v-for="itemSub in item.subMenu" :key="itemSub.route">
                        <RouterLink class="inline-flex cursor-pointer items-center" :to="{ name: itemSub.route }">
                            <i class="far fa-dot-circle text-[6px]"></i>
                            <span class="ml-1 capitalize">{{ itemSub.name }}</span>
                        </RouterLink>
                    </a-menu-item>
                </a-sub-menu>
            </a-menu>

            <div class="fixed bottom-0 mx-auto mt-3 block w-64 px-6 py-6">
                <button
                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-transparent bg-emerald-500 px-5 py-3 align-bottom font-medium leading-5 text-white transition-colors duration-150 hover:bg-emerald-600 focus:outline-none active:bg-emerald-600"
                    type="button">
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
import { ref, computed, watch } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import sidebar from '@/static/sidebar';
import _ from 'lodash';

const selectedKeys = ref([]);
const openKeys = ref([]);

const route = useRoute();


const menuItems = computed(() => {
    return sidebar.filter((item) => !item.subMenu || item.subMenu.length === 0);
});

const subMenuItems = computed(() => {
    return sidebar.filter((item) => item.subMenu && item.subMenu.length > 0);
});

const generateGeneralPattern = (route) => {
    if (!route) return '';
    const parts = route.split('.');

    if (parts.length > 1) {
        parts.pop();
    }

    return parts.join('.');
};

const isActiveRoute = (route, currentRoute) => {
    return generateGeneralPattern(route) === generateGeneralPattern(currentRoute);
};

const findSidebarItem = (currentRouteName, sidebar) => {
    return sidebar.find(item =>
        (item.subMenu.length && item.subMenu.some(sub => sub.route === currentRouteName)) ||
        (item.route && item.route === currentRouteName) ||
        (_.isArray(item.active) && item.active.includes(currentRouteName.split('.')[0]))
    );
};

const updateMenuState = () => {
    const currentRouteName = route.name;
    if (!currentRouteName) return;

    const foundItem = findSidebarItem(currentRouteName, sidebar);
    if (!foundItem) {
        openKeys.value = [];
        selectedKeys.value = [];
        return;
    }

    openKeys.value = [foundItem.id];

    const subItem = foundItem.subMenu.find(sub =>
        sub.route === currentRouteName || isActiveRoute(sub.route, currentRouteName)
    );

    selectedKeys.value = subItem ? [subItem.route] : [foundItem.route];
};

watch(() => route.name, () => {
    updateMenuState();
}, { immediate: true });
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
