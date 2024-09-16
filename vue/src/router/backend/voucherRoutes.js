import VoucherIndexView from '@/views/backend/voucher/voucher/IndexView.vue';
import VoucherStoreView from '@/views/backend/voucher/voucher/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const voucherRoutes = [
  {
    path: '/voucher/index',
    name: 'voucher.index',
    component: VoucherIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/voucher/store',
    name: 'voucher.store',
    component: VoucherStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/voucher/update/:id(\\d+)',
    name: 'voucher.update',
    component: VoucherStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default voucherRoutes;
