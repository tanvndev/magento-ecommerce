// plugins/pusher.js
import Pusher from 'pusher-js'

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig()
  const authStore = useAuthStore()
  const token = authStore.getToken
  const authEndpoint = config.public.LARAVEL_URL + '/broadcasting/auth'

  Pusher.logToConsole = true
  const pusher = new Pusher(config.public.PUSHER_APP_KEY, {
    cluster: config.public.PUSHER_APP_CLUSTER,
    encrypted: true,
    authEndpoint: authEndpoint,
    auth: {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    },
  })

  nuxtApp.provide('pusher', pusher)
})
