import { defineStore } from 'pinia'
import { useLoadingStore } from '#imports'

export const useProductStore = defineStore('product', {
  state: () => {
    return {
      product: null,
      isReload: true,
      productReviews: [],
    }
  },
  getters: {
    getProduct: (state) => state.product,
    getIsReload: (state) => state.isReload,
    getProductReviews: (state) => state.productReviews,
  },
  actions: {
    setIsReload(value) {
      this.isReload = value
    },
    setProduct(product) {
      this.product = product
    },
    setProductReviews(productReviews) {
      this.productReviews = productReviews
    },
  },
})
