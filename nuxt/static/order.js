const ORDER_STATUS_TABS = [
  {
    title: 'Tất cả',
    value: 'all',
  },
  {
    title: 'Chờ thanh toán',
    value: 'unpaid',
  },
  {
    title: 'Đang giao',
    value: 'delivering',
  },
  {
    title: 'Hoàn thành',
    value: 'completed',
  },
  {
    title: 'Đã huỷ',
    value: 'canceled',
  },
  {
    title: 'Trả hàng',
    value: 'returned',
  },
]

const ORDER_STATUS = [
  {
    title: 'Chờ thanh toán',
    value: 'pending',
    icon: 'mdi-clock',
  },
  {
    title: 'Đang giao',
    value: 'delivering',
    icon: 'mdi-truck-delivery',
  },
  {
    title: 'Hoàn thành',
    value: 'completed',
    icon: 'mdi-check-circle',
  },
  {
    title: 'Đã huỷ',
    value: 'canceled',
    icon: 'mdi-cancel',
  },
  {
    title: 'Trả hàng',
    value: 'returned',
    icon: 'mdi-undo-variant',
  },
]

export { ORDER_STATUS_TABS, ORDER_STATUS }
