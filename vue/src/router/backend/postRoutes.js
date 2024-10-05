import BrandIndexView from '@/views/backend/brand/brand/IndexView.vue';
import BrandStoreView from '@/views/backend/brand/brand/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const brandRoutes = [
  {
    path: '/brand/index',
    name: 'brand.index',
    component: BrandIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/brand/store',
    name: 'brand.store',
    component: BrandStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/brand/update/:id(\\d+)',
    name: 'brand.update',
    component: BrandStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default brandRoutes;
