<template>
  <div class="page-wrapper">
    <h1 class="d-none">Wolmart - Responsive Marketplace HTML Template</h1>
    <AppHeader />

    <main class="main" style="min-height: 100vh">
      <slot />
    </main>

    <AppFooter />
  </div>

  <!-- Start of Scroll Top -->
  <a
    ref="scrollTopRef"
    id="scroll-top"
    class="scroll-top"
    href="#top"
    title="Top"
    role="button"
    @click="scrollToTop"
    :class="{ show: showScrollTop }"
  >
    <i class="w-icon-angle-up"></i>
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
      <circle
        ref="progressIndicator"
        fill="transparent"
        stroke="#2c67e7"
        stroke-width="4"
        stroke-linecap="round"
        cx="35"
        cy="35"
        r="34"
      ></circle>
    </svg>
  </a>
  <!-- End of Scroll Top -->
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import AppFooter from '~/components/includes/AppFooter.vue'
import AppHeader from '~/components/includes/AppHeader.vue'
import Cookies from 'js-cookie'

const authStore = useAuthStore()
const token = ref(Cookies.get('token') || null)
const { $authService } = useNuxtApp()

const setTokenAndSetCurrentUser = async () => {
  if (token.value) {
    if (!authStore.getToken) {
      authStore.setToken(token.value)
    }
    const user = await $authService.me()

    authStore.setUser(user)
  }
}

const showScrollTop = ref(false)
const progressIndicator = ref(null)
const scrollTopRef = ref(null)

const checkScroll = () => {
  const scrollTop = window.scrollY
  const documentHeight = document.documentElement.scrollHeight
  const windowHeight = window.innerHeight
  const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100

  showScrollTop.value = scrollTop > 200

  if (progressIndicator.value) {
    const circumference = 2 * Math.PI * progressIndicator.value.r.baseVal.value
    const offset = circumference - (scrollPercent / 100) * circumference

    progressIndicator.value.style.strokeDasharray = `${circumference}px ${circumference}px`
    progressIndicator.value.style.strokeDashoffset = offset
  }
}

const scrollToTop = (event) => {
  event.preventDefault()
  window.scrollTo({
    top: 0,
    behavior: 'smooth',
  })
}

onMounted(() => {
  window.addEventListener('scroll', checkScroll)
  setTokenAndSetCurrentUser()
})

onUnmounted(() => {
  window.removeEventListener('scroll', checkScroll)
})
</script>
