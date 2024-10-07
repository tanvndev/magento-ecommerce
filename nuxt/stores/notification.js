import { defineStore } from 'pinia'
import { useLoadingStore } from '#imports'

export const useNotificationStore = defineStore('notification', {
  state: () => {
    return {
      notifications: [],
      notificationCount: 0,
    }
  },
  getters: {
    getNotifications: (state) => state.notifications,
  },
  actions: {
    async getAllNotifications() {
      const loadingStore = useLoadingStore()
      loadingStore.setLoading(true)
      const { $axios } = useNuxtApp()

      loadingStore.setLoading(true)

      try {
        const response = await $axios.get('/notifications')

        this.addNotification(response.data?.items)
        this.setNotificationCount(response.data?.items?.length)
      } catch (error) {
      } finally {
        loadingStore.setLoading(false)
      }
    },
    addNotification(notification) {
      this.notifications.unshift(notification)
    },
    setNotificationCount(count) {
      this.notificationCount = count
    },
    removeNotification(notification) {
      const index = this.notifications.indexOf(notification)
      if (index > -1) {
        this.notifications.splice(index, 1)
      }
    },
  },
})
