import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: '',
    isSignedIn: false,
  }),
  actions: {
    setToken(token) {
      this.token = token
      this.isSignedIn = true
    },
    getToken() {
      return this.token
    },
    signOut() {
      this.token = ''
      this.isSignedIn = false
    },
  },
})
