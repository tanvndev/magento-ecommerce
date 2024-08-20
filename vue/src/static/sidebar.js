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
    name: 'Thành viên',
    active: ['user'],
    subMenu: [
      {
        name: 'Danh sách thành viên',
        route: 'user.index'
      },
      {
        name: 'Danh sách khách hàng',
        route: 'user.index'
      },
      {
        name: 'Nhóm thành viên',
        route: 'user.catalogue.index'
      },
      {
        name: 'Quyền thành viên',
        route: 'permission.index'
      }
    ]
  },
  {
    id: 'attribute_sidebar',
    icon: 'fab fa-buffer',
    name: 'Thuộc tính',
    active: ['attribute'],
    subMenu: [
      {
        name: 'Nhóm thuộc tính',
        route: 'attribute.catalogue.index'
      },
      {
        name: 'Danh sách thuộc tính',
        route: 'attribute.index'
      }
    ]
  },
  {
    id: 'product_sidebar',
    icon: 'fas fa-box-check',
    name: 'Sản phẩm',
    active: ['product', 'brand'],
    subMenu: [
      {
        name: 'Danh sách thương hiệu',
        route: 'brand.index'
      },
      {
        name: 'Danh sách sản phẩm',
        route: 'product.index'
      },
      {
        name: 'Nhóm sản phẩm',
        route: 'product.catalogue.index'
      }
    ]
  },
  {
    id: 'warehouse_sidebar',
    icon: 'fas fa-warehouse-alt',
    name: 'Quản lý kho',
    route: ['warehouse'],
    subMenu: [
      {
        name: 'Kho hàng',
        route: 'warehouse.index'
      },
      {
        name: 'Tồn kho',
        route: 'warehouse.index'
      },
      {
        name: 'Nhập hàng',
        route: 'warehouse.index'
      },
      {
        name: 'Trả hàng nhập',
        route: 'warehouse.index'
      },
      {
        name: 'Nhà cung cấp',
        route: 'warehouse.index'
      }
    ]
  }
];
export default sidebar;
