import { defu } from 'defu'
import { useAuthStore } from '~/stores/auth'
import Cookies from 'js-cookie'

export function useIFetch(url, options = {}) {
  const config = useRuntimeConfig()
  const { isSignedIn, getToken, setToken, removeToken } = useAuthStore()
  const token = Cookies.get('token') || null

  const defaults = {
    baseURL: config.public.apiBaseUrl,
    key: url,
    server: false,
    retry: 1,
    retryStatusCodes: [401],
    retryDelay: 500,

    async onRequest({ options }) {
      if (token) {
        options.headers = {
          ...options.headers,
          Authorization: `Bearer ${token}`,
        }
      }
    },

    async onResponseError({ response, options }) {
      if (isSignedIn && response.status === 401) {
        try {
          const refreshResponse = await useFetch('/auth/refreshToken', {
            baseURL: config.public.apiBaseUrl,
            method: 'POST',
            server: false,
            credentials: 'include',
          })

          if (refreshResponse.status !== 200) {
            return {
              success: false,
              messages: refreshResponse.messages,
            }
          }

          const newToken = refreshResponse.data.access_token
          // set token to Cookie
          Cookies.set('token', newToken, {
            expires: parseInt(process.env.REFRESHTOKEN_EXPIRES),
          })

          // Extract new token from response
          if (newToken) {
            setToken(newToken)
            // Retry the original request with new token
            return useFetch(url, {
              ...options,
              headers: {
                ...options.headers,
                Authorization: `Bearer ${newToken}`,
              },
            })
          }
        } catch (error) {
          removeToken()
          console.error('Failed to refresh token')
        }
      }

      return response
    },
  }

  const params = defu(options, defaults)

  return useFetch(url, params)
}
