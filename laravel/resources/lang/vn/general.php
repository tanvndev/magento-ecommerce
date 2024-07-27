<?php
return [
    'publish' => [
        '-1' => 'Chọn tình trạng',
        '0' => 'Chưa xuất bản',
        '1' => 'Đã xuất bản',
    ],
    'follow' => [
        '-1' => 'Chọn điều hướng',
        '0' => 'Nofollow',
        '1' => 'Follow',
    ],
    'menuType' => [
        'dropdown-menu' => 'Dropdown Menu',
        'mega-menu' => 'Mega Menu',
    ],
    'effect' => [
        'fade' => 'Fade',
        'cube' => 'Cube',
        'coverflow' => 'Coverflow',
        'flip' => 'Flip',
        'cards' => 'Cards',
        'creative' => 'Creative',
    ],
    'navigate' => [
        'hide' => 'Ẩn',
        'dots' => 'Dấu chấm',
        'thumbnails' => 'Ảnh thumbnails',
    ],
    'promotion' => [
        'order_amount_range' => 'Chiết khấu theo tổng giá trị đơn hàng',
        'product_and_quantity' => 'Chiết khấu theo từng sản phẩm',
        'product_quantity_range' => 'Chiết khấu theo số lượng sản phẩm',
        'goods_discount_by_quantity' => 'Mua sản phẩm - giảm giá sản phẩm',

        'membership_discount' => 'Chiết khấu thành viên',
        'time_limited_offer' => 'Ưu đãi có hạn',
        'first_purchase_discount' => 'Chiết khấu cho lần mua hàng đầu tiên',
        'bundle_discount' => 'Chiết khấu gói sản phẩm',
        'coupon_code_discount' => 'Chiết khấu mã giảm giá',
        'free_shipping' => 'Miễn phí vận chuyển',
        'loyalty_program' => 'Chương trình khách hàng thân thiết',
        'seasonal_sale' => 'Khuyến mãi theo mùa',
        'flash_sale' => 'Khuyến mãi chớp nhoáng',
        'buy_one_get_one' => 'Mua một tặng một',
        'refer_a_friend_discount' => 'Chiết khấu giới thiệu bạn bè',
        'clearance_sale' => 'Khuyến mãi hàng dư',
        'birthday_discount' => 'Chiết khấu sinh nhật',
        'bulk_purchase_discount' => 'Chiết khấu mua hàng số lượng lớn',
    ],
    'promotion_select_product_and_quantity' => [
        'Product' => 'Phiên bản sản phẩm',
        'ProductCatalogue' => 'Loại sản phẩm',
    ],
    'apply_condition_item_select' => [
        [
            "id" => "staff_take_care_customer",
            "name" => "Nhân viên chăm sóc khách hàng",
        ],
        [
            "id" => "customer_group",
            "name" => "Nhóm khách hàng",
        ],
        [
            "id" => "customer_gender",
            "name" => "Giới tính",
        ],
        [
            "id" => "customer_birthday",
            "name" => "Ngày sinh",
        ],
    ],
    'gender' => [
        [
            'id' => 1,
            'name' => 'Nam'
        ],
        [
            'id' => 2,
            'name' => 'Nữ'
        ],
        [
            'id' => 3,
            'name' => 'Không xác định'
        ]
    ],
    'day' => array_map(function ($value) {
        return ['id' => $value - 1, 'name' => $value];
    }, range(1, 31)),

];
