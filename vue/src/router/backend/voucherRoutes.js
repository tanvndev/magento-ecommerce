import { isLoggedIn } from '@/middlewares/authenticate';

const voucherRoutes = [
  {
    path: '/voucher/index',
    name: 'voucher.index',
    component: () => import('@/views/backend/voucher/voucher/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/voucher/store',
    name: 'voucher.store',
    component: () => import('@/views/backend/voucher/voucher/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/voucher/update/:id(\\d+)',
    name: 'voucher.update',
    component: () => import('@/views/backend/voucher/voucher/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default voucherRoutes;
