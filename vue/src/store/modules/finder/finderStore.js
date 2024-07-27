// state
const state = {
  fileSeleted: null,
  fileListOld: null
};

// getters
const getters = {
  getFileSelected: (state) => state.fileSeleted
};
// actions
const actions = {
  setFileSelected({ commit }, { files }) {
    commit('setFileSelected', { files });
  }
};

// mutations

const mutations = {
  setFileSelected(state, { files }) {
    state.fileSeleted = files;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
