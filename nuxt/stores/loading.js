// stores/loadingStore.js
import { defineStore } from 'pinia'

export const useLoadingStore = defineStore('loading', {
  state: () => ({
    isLoading: false,
  }),
  getters: {
    getLoading: (state) => state.isLoading,
  },
  actions: {
    setLoading(value) {
      this.isLoading = value
    },
  },
})
