import { defineStore } from 'pinia'
import { useLoadingStore, useAuthStore } from '#imports'

export const useWishlistStore = defineStore('wishlist', {
  state: () => {
    return {
      wishlists: [],
      wishlistCount: 0,
    }
  },
  getters: {
    getWishlistCount: (state) => state.wishlistCount,
    getWishlists: (state) => state.wishlists,
  },
  actions: {
    setWishlistCount(count) {
      this.wishlistCount = count
    },
    setWishlists(wishlists) {
      this.wishlists = wishlists
    },
    async getAllWishlists(page = 1) {
      const authStore = useAuthStore()
      if (!authStore.isSignedIn) {
        return
      }
      const { $axios } = useNuxtApp()
      const loadingStore = useLoadingStore()

      loadingStore.setLoading(true)

      try {
        const response = await $axios.get('/wishlists/user?page=' + page)

        this.setWishlists(response.data)
        this.setWishlistCount(response.data?.total)
      } catch (error) {
      } finally {
        loadingStore.setLoading(false)
      }
    },
    async addToWishlist(payload) {
      const authStore = useAuthStore()
      if (!authStore.isSignedIn) {
        return toast('Vui lòng đăng nhập.', 'warning')
      }

      const { $axios } = useNuxtApp()

      if (!payload?.product_variant_id) {
        return toast('Có lỗi vui lòng thử lại.', 'error')
      }

      try {
        const response = await $axios.post('wishlists', payload)

        this.setWishlistCount(response.data?.total)
        toast(response.messages, response.status)
      } catch (error) {
        toast(error?.response?.data?.messages || 'Thao tác thất bại', 'error')
      }
    },
    async removeWishlist(id) {
      const authStore = useAuthStore()
      if (!authStore.isSignedIn) {
        return toast('Vui lòng đăng nhập.', 'warning')
      }
      const { $axios } = useNuxtApp()

      if (!id) {
        return toast('Có lỗi vui lòng thử lại.', 'error')
      }

      try {
        const response = await $axios.delete('wishlists/' + id)

        this.setWishlists(response.data)
        this.setWishlistCount(response.data?.total)
      } catch (error) {
        toast(error?.response?.data?.messages || 'Thao tác thất bại', 'error')
      }
    },
    removeAllWishlists() {
      this.wishlists = []
      this.wishlistCount = 0
    },
  },
})
