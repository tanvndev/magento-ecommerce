// plugins/pusher.js
import Pusher from 'pusher-js'

export default defineNuxtPlugin((nuxtApp) => {
  const pusher = new Pusher(process.env.PUSHER_APP_KEY, {
    cluster: process.env.PUSHER_APP_CLUSTER,
    encrypted: true,
  })

  nuxtApp.provide('pusher', pusher)
})
