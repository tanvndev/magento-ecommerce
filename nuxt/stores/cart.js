import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
  state: () => {
    return {
      carts: [],
      cartCount: 0,
      totalAmount: 0,
    }
  },
  getters: {
    getCartCount: (state) => state.cartCount,
    getCart: (state) => state.carts,
    getTotalAmount: (state) => state.totalAmount,
  },
  actions: {
    setCartCount(count) {
      this.cartCount = count
    },
    setCarts(carts) {
      this.carts = carts
    },
    setTotalAmount(amount) {
      this.totalAmount = amount
    },
    async getAllCarts() {
      const { $axios } = useNuxtApp()
      const response = await $axios.get('/carts')

      this.setCarts(response.data?.items)
      this.setCartCount(response.data?.items?.length)
      this.setTotalAmount(response.data?.total_amount)
    },
  },
})