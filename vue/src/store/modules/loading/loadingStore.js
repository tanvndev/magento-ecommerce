// state
const state = {
  isloading: false
};

// getters
const getters = {
  getIsLoading: (state) => state.isloading
};
// actions
const actions = {
  startLoading({ commit }) {
    commit('setLoading', true);
  },
  stopLoading({ commit }) {
    commit('setLoading', false);
  }
};

// mutations

const mutations = {
  setLoading(state, status) {
    state.isloading = status;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
