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
    id: 'voucher_sidebar',
    icon: 'fas fa-badge-percent text-[16px]',
    name: 'Khuyến mại',
    route: 'voucher.index',
    active: ['voucher'],
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
    id: 'post_sidebar',
    icon: 'fas fa-newspaper',
    name: 'Bài viết',
    active: ['user'],
    subMenu: [
      {
        name: 'Danh sách bài viết',
        route: 'user.index'
      },
      {
        name: 'Nhóm bài viết',
        route: 'user.index'
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
  },
  {
    id: 'live_chat_sidebar',
    icon: 'fas fa-comments',
    name: 'Nhắn tin',
    route: 'live-chat.index',
    subMenu: []
  },
  {
    id: 'order_sidebar',
    icon: 'fas fa-pallet-alt',
    name: 'Đơn hàng',
    active: ['order'],
    subMenu: [
      {
        name: 'Danh sách đơn hàng',
        route: 'order.index'
      }
    ]
  }
];
export default sidebar;
