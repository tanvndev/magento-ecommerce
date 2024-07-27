import ForgotView from '@/views/backend/auth/ForgotView.vue';
import LoginView from '@/views/backend/auth/LoginView.vue';
import RegisterView from '@/views/backend/auth/RegisterView.vue';

const userRoutes = [
  {
    path: '/admin',
    redirect: '/login'
  },

  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },
  {
    path: '/forgot-password',
    name: 'forgot',
    component: ForgotView
  }
];

export default userRoutes;
