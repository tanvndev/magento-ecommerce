import OrderIndexView from '@/views/backend/order/order/IndexView.vue';
import OrderStoreView from '@/views/backend/order/order/StoreView.vue';
import OrderUpdateView from '@/views/backend/order/order/UpdateView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const orderRoutes = [
  {
    path: '/order/index',
    name: 'order.index',
    component: OrderIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/order/store',
    name: 'order.store',
    component: OrderStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/order/update/:code',
    name: 'order.update',
    component: OrderUpdateView,
    beforeEnter: [isLoggedIn]
  }
];

export default orderRoutes;
