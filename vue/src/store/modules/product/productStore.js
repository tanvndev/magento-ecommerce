// state
const state = {
  attributes: []
};

// getters
const getters = {
  getAttributes: (state) => state.attributes,
  getAttributeIds: (state) => state.attributes.attrIds,
  getAttributeTexts: (state) => state.attributes.texts
};
// actions
const actions = {};

// mutations

const mutations = {
  setAttributes(state, attributes) {
    state.attributes = attributes;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
