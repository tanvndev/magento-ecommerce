import axios from 'axios';
import store from '@/store';
import Cookies from 'js-cookie';

const instance = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  withCredentials: true
});

let refreshTokenPromise = null;

// Add a request interceptor
instance.interceptors.request.use(
  function (config) {
    // Start loading
    // store.dispatch('loadingStore/startLoading');

    // Get token
    const token = Cookies.get('token') || null;

    if (token && token != null) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  function (error) {
    // Do something with request error
    return Promise.reject(error);
  }
);

// Add a response interceptor
instance.interceptors.response.use(
  function (response) {
    // Stop loading
    // store.dispatch('loadingStore/stopLoading');
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    return response.data;
  },
  async function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    const originalRequest = error.config;
    if (error.response.status === 401 && !originalRequest._retry) {
      if (!refreshTokenPromise) {
        originalRequest._retry = true;
        refreshTokenPromise = store
          .dispatch('authStore/refreshToken')
          .catch((err) => {
            // Nếu refresh token thất bại, reset promise
            refreshTokenPromise = null;
            store.dispatch('authStore/logout');
            return Promise.reject(err);
          })
          .finally(() => {
            // Reset promise khi hoàn thành
            refreshTokenPromise = null;
          });
      }

      // Chờ promise refresh token hoàn tất
      await refreshTokenPromise;
      return instance(originalRequest);
    }
    // Stop loading
    // store.dispatch('loadingStore/stopLoading');
    return Promise.reject(error);
  }
);

export default instance;
