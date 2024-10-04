import { isLoggedIn } from '@/middlewares/authenticate';

const attributeRoutes = [
  {
    path: '/attribute/index',
    name: 'attribute.index',
    component: () => import('@/views/backend/attribute/attribute/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/store',
    name: 'attribute.store',
    component: () => import('@/views/backend/attribute/attribute/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/update/:id(\\d+)',
    name: 'attribute.update',
    component: () => import('@/views/backend/attribute/attribute/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/value/store',
    name: 'attribute.value.store',
    component: () => import('@/views/backend/attribute/value/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/value/update/:id(\\d+)',
    name: 'attribute.value.update',
    component: () => import('@/views/backend/attribute/value/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default attributeRoutes;
