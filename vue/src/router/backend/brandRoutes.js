import { isLoggedIn } from '@/middlewares/authenticate';

const brandRoutes = [
  {
    path: '/brand/index',
    name: 'brand.index',
    component: () => import('@/views/backend/brand/brand/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/brand/store',
    name: 'brand.store',
    component: () => import('@/views/backend/brand/brand/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/brand/update/:id(\\d+)',
    name: 'brand.update',
    component: () => import('@/views/backend/brand/brand/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default brandRoutes;
