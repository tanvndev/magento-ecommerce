import { isLoggedIn } from '@/middlewares/authenticate';

const widgetRoutes = [
  {
    path: '/widget/index',
    name: 'widget.index',
    component: () => import('@/views/backend/widget/widget/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/widget/store',
    name: 'widget.store',
    component: () => import('@/views/backend/widget/widget/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/widget/update/:id(\\d+)',
    name: 'widget.update',
    component: () => import('@/views/backend/widget/widget/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default widgetRoutes;
