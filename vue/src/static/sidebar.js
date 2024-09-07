const sidebar = [
  {
    id: 'dashboard_sidebar',
    icon: 'fas fa-home-lg-alt',
    name: 'Dashboard',
    route: 'dashboard',
    subMenu: []
  },
  {
    id: 'widget_sidebar',
    icon: 'fas fa-shapes text-[16px]',
    name: 'Widget',
    route: 'widget.index',
    active: ['widget'],
    subMenu: []
  },
  {
    id: 'setting_sidebar',
    icon: 'fas fa-cog text-[16px]',
    name: 'Cấu hình',
    route: 'setting',
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
        name: 'Danh sách thuộc tính',
        route: 'attribute.index'
      },
      {
        name: 'Thêm mới giá trị',
        route: 'attribute.value.store'
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
  }
];
export default sidebar;
