import router from '@/router';
import AuthService from '@/services/AuthService';
import Cookies from 'js-cookie';

const token = Cookies.get('token') ?? null;
// state
const state = {
  status: token ? { loggedIn: true } : { loggedIn: false },
  accessToken: token ? token : null,
  user: null,
  messages: []
};

// getters
const getters = {
  isLoggedIn: (state) => state.status.loggedIn,
  getUser: (state) => state.user,
  getToken: (state) => state.accessToken,
  getMessages: (state) => state.messages,
  getRole: (state) => state.user?.user_catalogue
};
// actions
const actions = {
  async login({ commit }, payload) {
    const response = await AuthService.login(payload);
    if (!response.success) {
      return commit('loginFailure', response.messages);
    }
    return commit('loginSuccess', response.data);
  },
  async logout({ commit }) {
    commit('logout');
  },
  async refreshToken({ commit }) {
    const response = await AuthService.refreshToken();
    if (!response.success) {
      return commit('loginFailure', response.messages);
    }
    return commit('loginSuccess', response.data);
  }
};

// mutations

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  loginSuccess(state, token) {
    state.status.loggedIn = true;
    state.accessToken = token;
    state.messages = '';
  },
  loginFailure(state, message) {
    state.status.loggedIn = false;
    state.accessToken = null;
    state.user = null;
    state.messages = message;
  },
  refreshTokenSuccess(state, token) {
    state.status.loggedIn = true;
    state.accessToken = token;
  },
  refreshTokenFailure(state) {
    state.status.loggedIn = false;
    state.accessToken = null;
    state.user = null;
  },
  logout(state) {
    state.status.loggedIn = false;
    state.accessToken = null;
    state.messages = '';
    Cookies.remove('token');
    router.push('/login');
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
