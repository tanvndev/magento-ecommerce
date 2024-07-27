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
    id: 'product_sidebar',
    icon: 'fas fa-boxes',
    name: 'QL Sản phẩm',
    route: '',
    subMenu: [
      // {
      //   name: 'Quản lý thuộc tính',
      //   route: 'user.index'
      // },
      // {
      //   name: 'Quản lý nhóm thuộc tính',
      //   route: 'user.catalogue.index'
      // },
      {
        name: 'Quản lý sản phẩm',
        route: 'product.index'
      },
      {
        name: 'Quản lý nhóm sản phẩm',
        route: 'product.catalogue.index'
      }
    ]
  }
];
export default sidebar;
