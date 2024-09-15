import { defineStore } from 'pinia'

export const useProductCatalogueStore = defineStore('productCatalogue', {
  state: () => {
    return {
      productCatalogues: [],
    }
  },
  getters: {
    getProductCatalogues: (state) => state.productCatalogues,
  },
  actions: {
    setProductCatalogues(catalogues) {
      this.productCatalogues = catalogues
    },
  },
})
