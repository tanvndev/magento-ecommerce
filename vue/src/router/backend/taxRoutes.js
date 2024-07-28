import TaxIndexView from '@/views/backend/tax/tax/IndexView.vue';
import TaxStoreView from '@/views/backend/tax/tax/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const taxRoutes = [
  {
    path: '/tax/index',
    name: 'tax.index',
    component: TaxIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/tax/store',
    name: 'tax.store',
    component: TaxStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/tax/update/:id(\\d+)',
    name: 'tax.update',
    component: TaxStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default taxRoutes;
