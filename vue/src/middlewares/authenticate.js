import store from '@/store';

const isLoggedIn = (to, from, next) => {
  const isLoggedIn = store.getters['authStore/isLoggedIn'];
  if (!isLoggedIn) {
    next({ name: 'login' });
  }
  next();
};

export { isLoggedIn };
