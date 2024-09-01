// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-04-03',
  devtools: { enabled: true },
  app: {
    head: {
      link: [],
    },
  },
  css: [
    '~/assets/icons/fontawesome-5-pro/css/all.css',
    '~/assets/css/animate.min.css',
    '~/assets/css/style.min.css',
    '~/assets/css/main.min.css',
  ],
})
