import { isLoggedIn } from '@/middlewares/authenticate';

const liveChatRoutes = [
  {
    path: '/live-chat/index',
    name: 'live-chat.index',
    component: () => import('@/views/backend/chat/IndexView.vue'),
    beforeEnter: [isLoggedIn]
  }
];

export default liveChatRoutes;
