import { defineStore } from 'pinia'
import { useLoadingStore } from '#imports'

export const useOrderStore = defineStore('order', {
  state: () => {
    return {
      shippingFee: 0,
      discount: 0,
    }
  },
  getters: {
    getShippingFee: (state) => state.shippingFee,
    getDiscount: (state) => state.discount,
  },
  actions: {
    setShippingFee(value) {
      this.shippingFee = value
    },
    setDiscount(value) {
      this.discount = value
    },
  },
})
