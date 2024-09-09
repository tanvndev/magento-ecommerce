// plugins/axios.js
import { defineNuxtPlugin } from '#app'
import axios from 'axios'

export default defineNuxtPlugin((nuxtApp) => {
  const authStore = useAuthStore()
  const config = useRuntimeConfig()

  const instance = axios.create({
    baseURL: config.public.apiBaseUrl,
  })

  // Add a request interceptor
  instance.interceptors.request.use(
    function (config) {
      // Get token
      const token = authStore.getToken

      if (token) {
        config.headers.Authorization = `Bearer ${token}`
      }
      return config
    },
    function (error) {
      // Do something with request error
      return Promise.reject(error)
    }
  )

  // Add a response interceptor
  instance.interceptors.response.use(
    function (response) {
      // Any status code that lie within the range of 2xx cause this function to trigger
      return response.data
    },
    async function (error) {
      const originalRequest = error.config
      if (error.response?.status === 401 && !originalRequest._retry) {
        originalRequest._retry = true
        try {
          const response = await nuxtApp.$authService.refreshToken()

          if (!response.success) {
            authStore.removeToken()

            return Promise.reject('Token refresh failed')
          } else {
            authStore.setToken(response.data)

            // Retry the original request with the new token
            return instance(originalRequest)
          }
        } catch (e) {
          authStore.removeToken()
          return Promise.reject(e)
        }
      }
      return Promise.reject(error)
    }
  )

  nuxtApp.provide('axios', instance)
})
