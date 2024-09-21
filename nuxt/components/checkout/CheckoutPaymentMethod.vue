<template>
  <div class="payment-method">
    <h3 class="title text-uppercase ls-10 mb-5">Phương thức thanh toán</h3>

    <div
      class="card-container"
      v-for="item in paymentMethods"
      :key="item.id"
      :class="{ selected: isSelected === item.id }"
      @click="handleSelected(item.id)"
    >
      <span class="checked-icon"></span>
      <div class="card-main-content">
        <img class="card-icon" :src="item.image" />
        <div class="card-main-content-text-container">
          <p class="card-title">{{ item.name }}</p>
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
<script setup>
import { ref } from 'vue'

const emits = defineEmits(['onChange'])
const { $axios } = useNuxtApp()
const paymentMethods = ref([])
const isSelected = ref()

const handleSelected = (id) => {
  isSelected.value = id
  emits('onChange', id)
}

const getAllPaymentMethods = async () => {
  const response = await $axios.get('/getAllPaymentMethods')

  paymentMethods.value = response?.data
  isSelected.value = response?.data[0]?.id
}

onMounted(() => {
  getAllPaymentMethods()
})
</script>
