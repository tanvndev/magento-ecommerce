import { defineStore } from 'pinia'
import Cookies from 'js-cookie'
import { useRouter } from '#app' // Nuxt 3 router
import AuthService from '~/services/AuthService'

export const useAuthStore = defineStore('auth', {
  state: () => {
    const token = Cookies.get('token') ?? null

    return {
      status: { loggedIn: false },
      accessToken: token ? token : null,
      user: null,
      messages: [],
    }
  },
  getters: {
    isSignedIn: (state) => state.status.loggedIn,
    getUser: (state) => state.user,
    getToken: (state) => state.accessToken,
    getMessages: (state) => state.messages,
    getRole: (state) => state.user?.user_catalogue,
  },
  actions: {
    async logout() {
      this.status.loggedIn = false
      this.accessToken = null
      this.messages = ''
      Cookies.remove('token')
      const router = useRouter()
      router.push('/login')
    },
    setToken(token) {
      this.status.loggedIn = true
      this.accessToken = token
      this.messages = ''
    },
    removeToken() {
      this.status.loggedIn = false
      this.accessToken = null
      this.user = null
      this.messages = ''
    },
    setUser(user) {
      this.user = user
    },
  },
})
