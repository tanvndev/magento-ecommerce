import { defineStore } from 'pinia'

export const useChatStore = defineStore('chat', {
  state: () => {
    return {
      chatCount: 0,
    }
  },
  getters: {
    getChatCount: (state) => state.chatCount,
  },
  actions: {
    setChatCount(count) {
      this.chatCount = count
    },
    setChats(chats) {
      this.chats = chats
    },

    pushMessage(message) {
      this.chats.push(message)
    },
    async getAllChats() {
      const { $axios } = useNuxtApp()
      const loadingStore = useLoadingStore()
      const authStore = useAuthStore()

      loadingStore.setLoading(true)

      try {
        const endpoint = 'chats/user/list'

        const response = await $axios.get(endpoint)

        const unreadMessages = response.data.filter(
          (item) => item.read_at == null
        )

        console.log('Unread Messages:', unreadMessages)

        this.setChatCount(unreadMessages.length)
      } catch (error) {
      } finally {
        loadingStore.setLoading(false)
      }
    },
  },
})
