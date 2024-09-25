const ORDER_STATUS = [
  {
    label: 'Chờ thanh toán',
    value: 'pending'
  },
  {
    label: 'Đang giao',
    value: 'delivering'
  },
  {
    label: 'Hoàn thành',
    value: 'completed'
  },
  {
    label: 'Đã hủy',
    value: 'canceled'
  },
  {
    label: 'Trả hàng',
    value: 'returned'
  }
];

const PAYMENT_STATUS = [
  {
    label: 'Chưa thanh toán',
    value: 'unpaid'
  },
  {
    label: 'Đã thanh toán',
    value: 'paid'
  }
];

const DELYVERY_STATUS = [
  {
    label: 'Chờ giao',
    value: 'pending'
  },
  {
    label: 'Đang giao',
    value: 'delivering'
  },
  {
    label: 'Đã giao hàng',
    value: 'delivered'
  },
  {
    label: 'Giao thất bại',
    value: 'failed'
  }
];

export { ORDER_STATUS, PAYMENT_STATUS, DELYVERY_STATUS };
