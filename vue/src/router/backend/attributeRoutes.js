import AttributeIndexView from '@/views/backend/attribute/attribute/IndexView.vue';
import AttributeStoreView from '@/views/backend/attribute/attribute/StoreView.vue';
import AttributeValueStoreView from '@/views/backend/attribute/value/StoreView.vue';
import { isLoggedIn } from '@/middlewares/authenticate';

const attributeRoutes = [
  {
    path: '/attribute/index',
    name: 'attribute.index',
    component: AttributeIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/store',
    name: 'attribute.store',
    component: AttributeStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/update/:id(\\d+)',
    name: 'attribute.update',
    component: AttributeStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/value/store',
    name: 'attribute.value.store',
    component: AttributeValueStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/value/update/:id(\\d+)',
    name: 'attribute.value.update',
    component: AttributeValueStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default attributeRoutes;
