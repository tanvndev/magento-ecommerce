import AttributeIndexView from '@/views/backend/attribute/attribute/IndexView.vue';
import AttributeStoreView from '@/views/backend/attribute/attribute/StoreView.vue';
import AttributeCatalogueIndexView from '@/views/backend/attribute/catalogue/IndexView.vue';
import AttributeCatalogueStoreView from '@/views/backend/attribute/catalogue/StoreView.vue';
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
    path: '/attribute/catalogue/index',
    name: 'attribute.catalogue.index',
    component: AttributeCatalogueIndexView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/catalogue/store',
    name: 'attribute.catalogue.store',
    component: AttributeCatalogueStoreView,
    beforeEnter: [isLoggedIn]
  },
  {
    path: '/attribute/catalogue/update/:id(\\d+)',
    name: 'attribute.catalogue.update',
    component: AttributeCatalogueStoreView,
    beforeEnter: [isLoggedIn]
  }
];

export default attributeRoutes;
