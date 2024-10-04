import { isLoggedIn } from '@/middlewares/authenticate';

const orderRoutes = [
  {
    path: '/order/index',
    name: 'order.index',
    component: () => import('@/views/backend/order/order/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/order/store',
    name: 'order.store',
    component: () => import('@/views/backend/order/order/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/order/update/:code',
    name: 'order.update',
    component: () => import('@/views/backend/order/order/UpdateView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default orderRoutes;
