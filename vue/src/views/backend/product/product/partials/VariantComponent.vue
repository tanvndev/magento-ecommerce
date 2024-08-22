<template>
    <a-space class="w-full justify-between" :size="12">
        <a-button :loading="state.isLoading" :disabled="_.isEmpty(attributes.texts)" type="dashed"
            @click="handleCreateVariant">
            <i class="fas fa-layer-plus mr-2"></i>
            Tự động tạo biến thể
        </a-button>
        <span class="text-gray-500" v-if="!_.isEmpty(state.variantTexts)">(Tổng cộng: {{ state.variantTexts.length }}
            biến thể)
        </span>
    </a-space>

    <!-- Danh sách bien the -->
    <a-row class="mt-5 border-t pt-3" :gutter="[16, 10]" v-if="state.variantTexts.length">
        <!-- Attribute -->
        <a-col class="mb-4 border-b pb-5 first:mt-3 last:mb-0 last:border-b-0 last:pb-2" span="24"
            v-for="(variantText, i) in state.variantTexts" :key="variantText">
            <div class="flex items-center justify-between">
                <a-space>
                    <span class="mr-2 font-bold">#{{ i + 1 }}</span>
                    <span class="rounded-md bg-[#0000000a] px-4 py-2 font-bold text-primary-700">{{
                        variantText
                    }}</span>

                    <!-- Variant_count -->
                    <div class="hidden">
                        <InputComponent :name="`variable[count][${i}]`" :old-value="i + ''" />
                    </div>
                </a-space>
                <a-space>
                    <!-- Edit -->
                    <a-button @click="toggerOpenEdit(i)">
                        <i class="fas fa-pencil-alt"></i>
                    </a-button>
                    <!-- Delete -->
                    <a-popconfirm title="Bạn có chắc chắn muốn xóa?" ok-text="Xóa" cancel-text="Hủy"
                        @confirm="handleDeleteRowVariant(i)">
                        <a-button danger>
                            <i class="fas fa-trash-alt"></i>
                        </a-button>
                    </a-popconfirm>
                </a-space>
            </div>

            <!-- EditForm -->
            <a-row class="mt-3 border-t px-3 pt-3" :class="state.openEdit[i] ? 'block' : 'hidden'">
                <a-col span="24" class="mb-4 border-b pb-4">
                    <a-row :gutter="[16, 10]" class="items-center">
                        <a-col span="3" class="text-center">
                            <label class="font-bold">Ảnh</label>
                            <small class="block text-gray-500">(Mặc định sẽ lấy ảnh sản phẩm)</small>
                        </a-col>
                        <a-col span="5">
                            <InputFinderComponent :name="`variable[image][${i}]`" />
                        </a-col>
                        <a-col span="16">
                            <InputComponent :name="`variable[sku][${i}]`" label="SKU"
                                placeholder="Tự sinh nếu không nhập" />
                        </a-col>
                    </a-row>
                </a-col>
                <!-- Anh -->
                <a-col span="24" class="mb-4 border-b pb-4">
                    <a-row class="items-center" :gutter="[16, 10]">
                        <a-col span="3" class="text-center">
                            <label class="font-bold">Thư viện ảnh</label>
                            <small class="block text-gray-500">(Mặc định sẽ lấy ảnh thư viện sản phẩm)</small>
                        </a-col>
                        <a-col span="21">
                            <InputFinderComponent :name="`variable[album][${i}]`" :multipleFile="true" />
                        </a-col>
                    </a-row>
                </a-col>
                <!-- Gia -->
                <a-col span="24" class="mb-4 border-b pb-4">
                    <a-row class="items-center" :gutter="[16, 20]">
                        <a-col span="8">
                            <InputNumberComponent :name="`variable[price][${i}]`" label="Giá bán"
                                placeholder="Giá bán" />
                        </a-col>
                        <a-col span="8">
                            <InputNumberComponent :name="`variable[sale_price][${i}]`" label="Giá ưu đãi"
                                placeholder="Giá ưu đãi" />
                        </a-col>
                        <a-col span="8">
                            <InputNumberComponent :name="`variable[cost_price][${i}]`" label="Giá nhập"
                                placeholder="Giá nhập" />
                        </a-col>
                        <!-- Discount_time -->
                        <a-col>
                            <SwitchComponent :name="`variable[is_discount_time][${i}]`" checkText="Lên lịch"
                                uncheckText="Hủy lên lịch" @onChange="handleDiscountTime($event, i)" />
                        </a-col>
                        <a-col span="24" v-if="state.isDiscountTime[i]">
                            <InputDateComponent type="date-range" :name="`variable[sale_price_time][${i}]`"
                                :showTime="true" />
                        </a-col>
                    </a-row>
                </a-col>
                <!-- Giao hang -->
                <a-col span="24">
                    <a-row class="items-center" :gutter="[16, 10]">
                        <a-col span="6">
                            <InputNumberComponent :name="`variable[weight][${i}]`" label="Cân nặng (g)"
                                placeholder="Cân nặng" />
                        </a-col>
                        <a-col span="6">
                            <InputNumberComponent :name="`variable[length][${i}]`" label="Dài (cm)" placeholder="Dài" />
                        </a-col>
                        <a-col span="6">
                            <InputNumberComponent :name="`variable[width][${i}]`" label="Rộng (cm)"
                                placeholder="Rộng" />
                        </a-col>
                        <a-col span="6">
                            <InputNumberComponent :name="`variable[height][${i}]`" label="Cao (cm)" placeholder="Cao" />
                        </a-col>
                    </a-row>
                </a-col>
            </a-row>
        </a-col>
    </a-row>
</template>
<script setup>
import _ from 'lodash';
import { computed, reactive } from 'vue';
import {
    InputNumberComponent,
    SwitchComponent,
    InputComponent,
    InputDateComponent,
    InputFinderComponent
} from '@/components/backend';
import { useStore } from 'vuex';

const store = useStore();
const attributes = computed(() => store.getters['productStore/getAttributes']);

// STATE
const state = reactive({
    openEdit: {},
    variantTexts: [],
    isLoading: false,
    isDiscountTime: {}
});

// XU LY TAO RA CAC BIEN THE
const handleCreateVariant = () => {
    state.isLoading = true;

    const attributeTexts = attributes.value.texts;
    console.log(attributeTexts);


    if (_.isEmpty(attributeTexts)) {
        state.isLoading = false;

        return store.dispatch('antStore/showMessage', {
            type: 'error',
            message: 'Vui lòng chọn thuộc tính sản phẩm trước khi tạo biến thể.'
        });
    }

    // const variantTextData = combineVariant(attributeTexts);
    const { variantTexts, variantIds } = combineVariant(attributeTexts);

    console.log(variantTexts, variantIds);


    store.commit('productStore/setVariants', {variantTexts, variantIds});

    setTimeout(() => {
        state.variantTexts = variantTexts;
    }, 1000);

    setTimeout(() => {
        state.isLoading = false;
    }, 1000);
};

const calculateVariant = (obj) => {
    const arrays = Object.values(obj);
    if (arrays.length === 0) return [];
    return arrays.reduce(
        (acc, curr) => {
            return acc.flatMap(a => curr.map(b => a.concat([b])));
        },
        [[]]
    );
};

const combineVariant = (variants) => {
    const combinations = calculateVariant(variants);

    const variantTexts = combinations.map(combination =>
        combination
            .map(item => item[1])
            .join(' - ')
    );

    const variantIds = combinations.map(combination =>
        combination
            .map(item => item[0])
            .sort((a, b) => a - b)
            .join(',')
    );
    return { variantTexts, variantIds };
};

// XU LY XOA CAC HANG BIEN THE
const handleDeleteRowVariant = (index) => {
    state.variantTexts.splice(index, 1);
};

// XU LY CO THOI GIAN CHO GIAM GIA CHO BIEN THE KHONG
const handleDiscountTime = (value, index) => {
    state.isDiscountTime[index] = value;
};

// DONG MO CHUC NANG CHINH SUA THEO HANG
const toggerOpenEdit = (itemId) => {
    state.openEdit[itemId] = !state.openEdit[itemId];
};
</script>
