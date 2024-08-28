import ProductIndexView from '@/views/backend/product/product/IndexView.vue';
import ProductStoreView from '@/views/backend/product/product/StoreView.vue';
import ProductUpdateView from '@/views/backend/product/product/UpdateView.vue';
import ProductCatalogueIndexView from '@/views/backend/product/catalogue/IndexView.vue';
import ProductCatalogueStoreView from '@/views/backend/product/catalogue/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const productRoutes = [
  {
    path: '/product/index',
    name: 'product.index',
    component: ProductIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/store',
    name: 'product.store',
    component: ProductStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/update/:id(\\d+)',
    name: 'product.update',
    component: ProductUpdateView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/catalogue/index',
    name: 'product.catalogue.index',
    component: ProductCatalogueIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/catalogue/store',
    name: 'product.catalogue.store',
    component: ProductCatalogueStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/catalogue/update/:id(\\d+)',
    name: 'product.catalogue.update',
    component: ProductCatalogueStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default productRoutes;
