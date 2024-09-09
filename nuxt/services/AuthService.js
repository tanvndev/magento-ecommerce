// services/authService.js
import Cookies from 'js-cookie'

class AuthService {
  constructor(axios) {
    this.axios = axios
  }

  async refreshToken() {
    try {
      const response = await this.axios.post('/auth/refreshToken', {})

      if (response.status !== 200) {
        return {
          success: false,
          messages: response.data.messages || [],
        }
      }

      const token = response.data.access_token
      // Set token to Cookie
      Cookies.set('token', token, {
        expires: parseInt(process.env.REFRESHTOKEN_EXPIRES, 10),
      })

      return {
        success: true,
        data: token,
      }
    } catch (error) {
      return {
        success: false,
        messages: [error.message],
      }
    }
  }

  async me() {
    const { $axios } = useNuxtApp()

    try {
      const response = await $axios.get('/auth/me')

      return {
        success: true,
        data: response,
      }
    } catch (error) {
      return {
        success: false,
        messages: [error.message],
      }
    }
  }
}

export default function createAuthService(axios) {
  return new AuthService(axios)
}
