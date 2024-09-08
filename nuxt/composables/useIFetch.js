import { defu } from 'defu'
import { useAuthStore } from '@/stores/authStore'

export function useIFetch(url, options = {}) {
  const config = useRuntimeConfig()
  const { isSignedIn, getToken, setToken } = useAuthStore()

  const defaults = {
    baseURL: config.public.apiBaseUrl,
    key: url,
    server: false,
    retry: 1,
    retryStatusCodes: [401],
    retryDelay: 500,

    async onRequest({ options }) {
      if (isSignedIn) {
        options.headers = {
          ...options.headers,
          Authorization: `Bearer ${getToken()}`,
        }
      }
    },

    async onResponseError({ response, options }) {
      if (response.status === 401) {
        try {
          const refreshResponse = await useFetch('/auth/refresh', {
            baseURL: config.public.apiBaseUrl,
            method: 'POST',
            server: false,
            credentials: 'include',
          })

          // Extract new token from response
          if (refreshResponse.data?.token) {
            setToken(refreshResponse.data.token)
            // Retry the original request with new token
            return useFetch(url, {
              ...options,
              headers: {
                ...options.headers,
                Authorization: `Bearer ${getToken()}`,
              },
            })
          }
        } catch (error) {
          console.error('Failed to refresh token:', error)
        }
      }

      return response
    },
  }

  const params = defu(options, defaults)

  return useFetch(url, params)
}
