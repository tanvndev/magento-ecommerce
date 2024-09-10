// plugins/authService.js
import { defineNuxtPlugin } from '#app'
import createAuthService from '~/services/AuthService'

export default defineNuxtPlugin((nuxtApp) => {
  const authService = createAuthService(nuxtApp.$axios)
  nuxtApp.provide('authService', authService)
})
