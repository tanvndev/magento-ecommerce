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
    label: 'Chờ thanh toán',
    value: 'pending',
  },
  {
    label: 'Đang giao',
    value: 'delivering',
  },
  {
    label: 'Hoàn thành',
    value: 'completed',
  },
  {
    label: 'Đã hủy',
    value: 'canceled',
  },
  {
    label: 'Trả hàng',
    value: 'returned',
  },
]

const PAYMENT_STATUS = [
  {
    value: 'unpaid',
    label: 'Chưa thanh toán',
  },
  {
    value: 'paid',
    label: 'Đã thanh toán',
  },
]

const DELYVERY_STATUS = [
  {
    value: 'pending',
    label: 'Chờ giao',
  },
  {
    value: 'delivering',
    label: 'Đang giao',
  },
  {
    value: 'delivered',
    label: 'Đã giao hàng',
  },
  {
    value: 'failed',
    label: 'Giao thất bại',
  },
]

export { ORDER_STATUS_TABS, ORDER_STATUS, PAYMENT_STATUS, DELYVERY_STATUS }
