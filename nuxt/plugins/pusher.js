// plugins/pusher.js
import Pusher from 'pusher-js'

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig()
  const authStore = useAuthStore()
  const token = authStore.getToken

  Pusher.logToConsole = true
  const pusher = new Pusher(config.public.PUSHER_APP_KEY, {
    cluster: config.public.PUSHER_APP_CLUSTER,
    encrypted: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    },
  })

  nuxtApp.provide('pusher', pusher)
})
