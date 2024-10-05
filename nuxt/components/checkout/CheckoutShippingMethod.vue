<script setup>
import { ref } from 'vue'
import { useCartStore, useOrderStore, useLoadingStore } from '#imports'
import { useField } from 'vee-validate'

const { $axios } = useNuxtApp()
const cartStore = useCartStore()
const orderStore = useOrderStore()
const loadingStore = useLoadingStore()
const { value, errorMessage } = useField('shipping_method_id')

const shippingMethods = ref([])
const isSelected = ref(1)
const productVariantIds = ref('')
const carts = computed(() => cartStore.getCartSelected)

const handleSelected = (id) => {
  isSelected.value = id

  const shippingMethod = shippingMethods.value?.find((item) => item.id == id)

  orderStore.setShippingFee(shippingMethod?.base_cost)

  value.value = id
}

const getAllShippingMethods = async (productVariantIds) => {
  if (!productVariantIds) {
    return
  }

  try {
    loadingStore.setLoading(true)
    const response = await $axios.get(
      `/shipping-methods/products/${productVariantIds}`
    )

    shippingMethods.value = response?.data
    isSelected.value = response?.data[0]?.id
    orderStore.setShippingFee(response?.data[0]?.base_cost)

    value.value = response?.data[0]?.id
  } catch (error) {
  } finally {
    loadingStore.setLoading(false)
  }
}

const getProductVariantIds = () => {
  productVariantIds.value = carts.value
    ?.map((cart) => cart.product_variant_id)
    .join(',')
}

watch(productVariantIds, async (newValue) => {
  await getAllShippingMethods(newValue)
})

watch(carts, () => {
  getProductVariantIds()
})

onMounted(async () => {
  if (!carts.value.length) {
    await cartStore.getAllCarts()
  }
  getProductVariantIds()
})
</script>

<template>
  <div class="payment-method">
    <h3 class="title text-uppercase ls-10 mb-5">Hình thức vận chuyển</h3>

    <div
      class="card-container"
      v-for="item in shippingMethods"
      :key="item.id"
      :class="{
        selected: isSelected === item.id,
        error: errorMessage,
      }"
      @click="handleSelected(item.id)"
    >
      <span class="checked-icon"></span>
      <div class="card-main-content">
        <img class="card-icon" :src="item.image" />
        <div class="card-main-content-text-container">
          <p class="card-title">{{ item.name }}</p>
          <span class="base-cost">{{ formatCurrency(item.base_cost) }}</span>
        </div>
      </div>
      <div class="card-footer">
        <div class="card-footer-left">
          <div class="card-complex-description-wrapper">
            <p class="mb-0">{{ item.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
