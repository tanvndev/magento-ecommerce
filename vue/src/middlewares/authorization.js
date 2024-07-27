import store from '@/store';

const isAdmin = (to, from, next) => {
  const role = store.getters['authStore/getRole'];
  if (!role || role !== 'admin') {
    next({ name: 'login' });
  }
  next();
};

export { isAdmin };
