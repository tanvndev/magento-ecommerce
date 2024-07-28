const sidebar = [
  {
    id: 'dashboard_sidebar',
    icon: 'fas fa-home-lg-alt',
    name: 'Dashboard',
    route: 'dashboard',
    subMenu: []
  },
  {
    id: 'user_sidebar',
    icon: 'fas fa-users-medical',
    name: 'QL Thành viên',
    route: '',
    subMenu: [
      {
        name: 'Quản lý thành viên',
        route: 'user.index'
      },
      {
        name: 'Quản lý nhóm thành viên',
        route: 'user.catalogue.index'
      },
      {
        name: 'Quản lý quyền',
        route: 'permission.index'
      }
    ]
  },
  {
    id: 'attribute_sidebar',
    icon: 'fab fa-buffer',
    name: 'QL Thuộc tính',
    route: '',
    subMenu: [
      {
        name: 'Quản nhóm thuộc tính',
        route: 'attribute.catalogue.index'
      },
      {
        name: 'Quản thuộc tính',
        route: 'attribute.index'
      }
    ]
  },
  {
    id: 'product_sidebar',
    icon: 'fas fa-box-check',
    name: 'QL Sản phẩm',
    route: '',
    subMenu: [
      {
        name: 'Quản lý thương hiệu',
        route: 'brand.index'
      },
      {
        name: 'Quản lý nhà cung cấp',
        route: 'supplier.index'
      },
      {
        name: 'Quản lý thuế suất',
        route: 'tax.index'
      },

      {
        name: 'Quản lý sản phẩm',
        route: 'product.index'
      },
      {
        name: 'Quản lý nhóm sản phẩm',
        route: 'product.catalogue.index'
      }
    ]
  },
  {
    id: 'warehouse_sidebar',
    icon: 'fas fa-warehouse-alt',
    name: 'QL kho hàng',
    route: '',
    subMenu: [
      {
        name: 'Quản lý kho hàng',
        route: 'warehouse.index'
      }
    ]
  }
];
export default sidebar;
