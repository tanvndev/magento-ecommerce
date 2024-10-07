// plugins/pusher.js
import Pusher from 'pusher-js'

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig()

  const pusher = new Pusher(config.public.PUSHER_APP_KEY, {
    cluster: config.public.PUSHER_APP_CLUSTER,
    encrypted: true,
  })

  nuxtApp.provide('pusher', pusher)
})
