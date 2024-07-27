import WarehouseIndexView from '@/views/backend/warehouse/warehouse/IndexView.vue';
import WarehouseStoreView from '@/views/backend/warehouse/warehouse/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const warehouseRoutes = [
  {
    path: '/warehouse/index',
    name: 'warehouse.index',
    component: WarehouseIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/warehouse/store',
    name: 'warehouse.store',
    component: WarehouseStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/warehouse/update/:id(\\d+)',
    name: 'warehouse.update',
    component: WarehouseStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default warehouseRoutes;
