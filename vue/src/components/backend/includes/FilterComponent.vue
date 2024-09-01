<template>
    <a-card class="mt-3">
        <a-space :size="12" class="flex justify-end">
            <a-select v-if="removeRouteHide()" @change="handleFilterChange" v-model:value="filterOptions.publish"
                class="w-[200px]" :options="publishFilter">
            </a-select>
            <a-input-search @change="handleFilterChange" v-model:value="filterOptions.search"
                placeholder="Nhập vào để tìm kiếm..." enter-button @search="onSearch" />
        </a-space>
    </a-card>
</template>

<script setup>
import { reactive } from 'vue';
import { debounce } from '@/utils/helpers';
import { PUBLISH as publishFilter } from '@/static/constants';
import { useRoute } from 'vue-router';

const route = useRoute();
const emits = defineEmits(['onFilter', 'onSearch']);
const filterOptions = reactive({
    publish: 0,
    search: ''
});
const removeRouteHide = () => {
    const routeHide = ['permission.index', 'supplier.index', 'attribute.index', 'attribute.update'];
    if (routeHide.includes(route.name)) {
        return false;
    }
    return true;
};

const onSearch = (searchValue) => {
    filterOptions.search = searchValue;
    emits('onFilter', filterOptions);
};

const handleFilterChange = debounce(() => {
    emits('onFilter', filterOptions);
}, 500);
</script>
