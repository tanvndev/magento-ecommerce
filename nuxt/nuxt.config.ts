// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-04-03',
  devtools: { enabled: true },
  components: true,
  plugins: ['~/plugins/axios.js', '~/plugins/authService.js'],
  runtimeConfig: {
    public: {
      apiBaseUrl: process.env.API_BASE_URL,
    },
  },

  app: {
    head: {
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1',
      link: [],
    },
  },

  css: [
    '~/assets/icons/fontawesome-5-pro/css/all.css',
    '~/assets/css/animate.min.css',
    '~/assets/css/style.min.css',
    // '~/assets/css/main.min.css',
    '~/assets/css/custom.css',
    '~/assets/css/helpers.css',
  ],
  pinia: {
    storesDirs: ['./stores/**'],
  },

  modules: [
    '@nuxt/scripts',
    '@pinia/nuxt',
    'nuxt-lodash',
    'nuxt-swiper',
    'nuxt-easy-lightbox',
    'vuetify-nuxt-module',
  ],
})
