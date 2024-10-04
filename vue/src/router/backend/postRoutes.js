import { isLoggedIn } from '@/middlewares/authenticate';

const postRoutes = [
  {
    path: '/post/index',
    name: 'post.index',
    component: () => import('@/views/backend/post/post/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/post/store',
    name: 'post.store',
    component: () => import('@/views/backend/post/post/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/post/update/:id(\\d+)',
    name: 'post.update',
    component: () => import('@/views/backend/post/post/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/post/catalogue/index',
    name: 'post.catalogue.index',
    component: () => import('@/views/backend/post/catalogue/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/post/catalogue/store',
    name: 'post.catalogue.store',
    component: () => import('@/views/backend/post/catalogue/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/post/catalogue/update/:id(\\d+)',
    name: 'post.catalogue.update',
    component: () => import('@/views/backend/post/catalogue/StoreView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default postRoutes;
