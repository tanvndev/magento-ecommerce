// state
const state = {
  productType: '',
  attributes: {
    enable_variation: false,
    attrIds: [],
    texts: []
  },
  variants: {
    variantIds: [],
    variantTexts: []
  },
  price: {
    cost_price: 0,
    price: 0
  },
  attributeData: [],
  attributeEnableOld: [],
  attributeEnableIds: [],
  attributeNotEnableOld: [],
  attributeNotEnableIds: []
};

// getters
const getters = {
  getProductType: (state) => state.productType,
  getAttributes: (state) => state.attributes,
  getEnableVariation: (state) => state.attributes.enable_variation,
  getAttributeIds: (state) => state.attributes.attrIds,
  getAttributeTexts: (state) => state.attributes.texts,
  getVariants: (state) => state.variants,
  getPrice: (state) => state.price.price,
  getCostPrice: (state) => state.price.cost_price,
  getAttributeData: (state) => state.attributeData,
  getAttributeEnableOld: (state) => state.attributeEnableOld,
  getAttributeEnableIds: (state) => state.attributeEnableIds,
  getAttributeNotEnableOld: (state) => state.attributeNotEnableOld,
  getAttributeNotEnableIds: (state) => state.attributeNotEnableIds
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
  },
  setProductType(state, productType) {
    state.productType = productType;
  },
  setPrice(state, price) {
    state.price.price = price;
  },
  setCostPrice(state, costPrice) {
    state.price.cost_price = costPrice;
  },
  removeVariant(state, index) {
    if (index >= 0 && index < state.variants.variantIds.length) {
      state.variants.variantIds.splice(index, 1);
      state.variants.variantTexts.splice(index, 1);
    }
  },
  setAttributeData(state, attributeData) {
    state.attributeData = attributeData;
  },
  setAttributeEnableOld(state, attributeEnableOld) {
    state.attributeEnableOld = attributeEnableOld;
  },
  setAttributeEnableIds(state, attributeEnableIds) {
    state.attributeEnableIds = attributeEnableIds;
  },
  setAttributeNotEnableOld(state, attributeNotEnableOld) {
    state.attributeNotEnableOld = attributeNotEnableOld;
  },
  setAttributeNotEnableIds(state, attributeNotEnableIds) {
    state.attributeNotEnableIds = attributeNotEnableIds;
  },
  removeAll(state) {
    state.variants = {};
    state.attributes = {};
    state.productType = '';
    state.price = {};
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
