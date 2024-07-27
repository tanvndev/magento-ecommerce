import SupplierIndexView from '@/views/backend/supplier/supplier/IndexView.vue';
import SupplierStoreView from '@/views/backend/supplier/supplier/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const supplierRoutes = [
  {
    path: '/supplier/index',
    name: 'supplier.index',
    component: SupplierIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/supplier/store',
    name: 'supplier.store',
    component: SupplierStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/supplier/update/:id(\\d+)',
    name: 'supplier.update',
    component: SupplierStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default supplierRoutes;
