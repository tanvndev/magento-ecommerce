import { useAuthStore } from '@/stores/auth'

export default defineNuxtRouteMiddleware((to, from) => {
  const authStore = useAuthStore()
  const isLoggedIn = authStore.isSignedIn

  if (!isLoggedIn && to.path.startsWith('/user')) {
    return navigateTo('/')
  }
})
