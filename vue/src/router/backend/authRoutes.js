const userRoutes = [
  {
    path: '/admin',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/backend/auth/LoginView.vue')
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/views/backend/auth/RegisterView.vue')
  },
  {
    path: '/forgot-password',
    name: 'forgot',
    component: () => import('@/views/backend/auth/ForgotView.vue')
  }
];

export default userRoutes;
