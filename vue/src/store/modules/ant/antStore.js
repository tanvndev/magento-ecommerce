// state
const state = {
  isShow: false,
  type: '',
  message: ''
};

// getters
const getters = {
  getIsShow: (state) => state.isShow,
  getType: (state) => state.type,
  getMessage: (state) => state.message
};
// actions
const actions = {
  showMessage({ commit }, { type, message }) {
    commit('setMessage', { type, message });
  },
  removeMessage({ commit }) {
    commit('removeMessage');
  }
};

// mutations

const mutations = {
  setMessage(state, { type, message }) {
    state.isShow = true;
    state.type = type;
    state.message = message;
  },
  removeMessage(state) {
    state.isShow = false;
    state.type = '';
    state.message = '';
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
