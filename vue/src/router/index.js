import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store';

import DashboardView from '@/views/backend/DashboardView.vue';

import {
  userRoutes,
  authRoutes,
  productRoutes,
  brandRoutes,
  supplierRoutes,
  warehouseRoutes,
  attributeRoutes
} from './backend';

import { isLoggedIn } from '@/middlewares/authenticate';
// import { isAdmin } from '@/middlewares/authorization';

const routes = [
  {
    path: '/',
    redirect: '/dashboard'
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/components/backend/layouts/NotFound.vue')
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView,
    beforeEnter: [isLoggedIn]
  },
  ...userRoutes,
  ...authRoutes,
  ...productRoutes,
  ...brandRoutes,
  ...supplierRoutes,
  ...warehouseRoutes,
  ...productRoutes,
  ...attributeRoutes
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

router.beforeEach((to, from, next) => {
  store.dispatch('loadingStore/startLoading');
  next();
});

router.afterEach(() => {
  store.dispatch('loadingStore/stopLoading');
});

export default router;
