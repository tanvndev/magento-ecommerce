// state
const state = {
  attributes: [],
  variants: []
};

// getters
const getters = {
  getAttributes: (state) => state.attributes,
  getAttributeIds: (state) => state.attributes.attrIds,
  getAttributeTexts: (state) => state.attributes.texts,
  getVariants: (state) => state.variants
};
// actions
const actions = {};

// mutations

const mutations = {
  setAttributes(state, attributes) {
    state.attributes = attributes;
  },
  setVariants(state, variants) {
    state.variants = variants;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
