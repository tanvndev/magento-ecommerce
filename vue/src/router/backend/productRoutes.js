import { isLoggedIn } from '@/middlewares/authenticate';

const productRoutes = [
  {
    path: '/product/index',
    name: 'product.index',
    component: () => import('@/views/backend/product/product/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/store',
    name: 'product.store',
    component: () => import('@/views/backend/product/product/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/update/:id(\\d+)',
    name: 'product.update',
    component: () => import('@/views/backend/product/product/UpdateView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/catalogue/index',
    name: 'product.catalogue.index',
    component: () => import('@/views/backend/product/catalogue/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/catalogue/store',
    name: 'product.catalogue.store',
    component: () => import('@/views/backend/product/catalogue/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/product/catalogue/update/:id(\\d+)',
    name: 'product.catalogue.update',
    component: () => import('@/views/backend/product/catalogue/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default productRoutes;
