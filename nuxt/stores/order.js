import { defineStore } from 'pinia'

export const useOrderStore = defineStore('order', {
  state: () => {
    return {
      shippingFee: 0,
      discount: 0,
      orderDetail: [],
    }
  },
  getters: {
    getShippingFee: (state) => state.shippingFee,
    getDiscount: (state) => state.discount,
    getOrderDetail: (state) => state.orderDetail,
  },
  actions: {
    setShippingFee(value) {
      this.shippingFee = value
    },
    setDiscount(value) {
      this.discount = value
    },
    setOrderDetail(value) {
      this.orderDetail = value
    },
  },
})
