<?php
return [
    'dashboard' => [
        'index' => [
            'title' => 'Bảng điều khiển',
        ],
    ],
    'system' => [
        'index' => [
            'title' => 'Cài đặt cấu hình hệ thống',
            'table' => 'Thông tin nhóm hình ảnh',
            'create' => 'Tạo mới nhóm hình ảnh'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm hình ảnh',
            'success' => 'Tạo mới nhóm hình ảnh thành công.',
            'error' => 'Tạo mới nhóm hình ảnh thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập cấu hình hệ thống',
            'success' => 'Cập nhập cấu hình hệ thống thành công.',
            'error' => 'Cập nhập cấu hình hệ thống thất bại.',
        ],
        'delete' => [
            'title' => 'Cập nhập nhóm hình ảnh',
            'success' => 'Xoá nhóm hình ảnh thành công.',
            'error' => 'Xoá nhóm hình ảnh thất bại.',
        ],

    ],
    'menu' => [
        'index' => [
            'table' => 'Thông tin menu',
            'create' => 'Tạo mới menu'
        ],
        'show' => [
            'title' => 'Danh sách menu',
            'success' => 'Cập nhập danh sách menu thành công.',
            'error' => 'Cập nhập danh sách menu thất bại.',

        ],
        'create' => [
            'title' => 'Tạo mới menu',
            'success' => 'Tạo mới menu thành công.',
            'error' => 'Tạo mới menu thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập menu cấp 1',
            'success' => 'Cập nhập menu thành công.',
            'error' => 'Cập nhập menu thất bại.',
        ],
        'children' => [
            'title' => 'Cập nhập menu con cho mục',
            'success' => 'Cập nhập menu con thành công.',
            'error' => 'Cập nhập menu con thất bại.',
        ],
        'translate' => [
            'title' => 'Cập nhật bản dịch cho menu',
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá menu thành công.',
            'error' => 'Xoá menu thất bại.',
        ],

    ],
    'menuCatalogue' => [
        'index' => [
            'table' => 'Thông tin nhóm menu',
            'create' => 'Tạo mới nhóm menu'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm menu',
            'success' => 'Tạo mới nhóm menu thành công.',
            'error' => 'Tạo mới nhóm menu thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm menu',
            'success' => 'Cập nhập nhóm menu thành công.',
            'error' => 'Cập nhập nhóm menu thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm menu thành công.',
            'error' => 'Xoá nhóm menu thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm menu',
        ]

    ],
    'order' => [
        'index' => [
            'table' => 'Thông tin đơn hàng',
            'create' => 'Tạo mới đơn hàng'
        ],
        'create' => [
            'title' => 'Tạo mới đơn hàng',
            'success' => 'Tạo mới đơn hàng thành công.',
            'error' => 'Tạo mới đơn hàng thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập đơn hàng',
            'success' => 'Cập nhập đơn hàng thành công.',
            'error' => 'Cập nhập đơn hàng thất bại.',
        ],
        'detail' => [
            'title' => 'Chi tiết đơn hàng',
            'info' => 'Thông tin khách hàng',
            'address' => 'Thông tin giao hàng',
            'success' => 'Cập nhập thông tin đơn hàng thành công.',
            'error' => 'Cập nhập thông tin đơn hàng thành công.',
        ],
        'table' => [
            'name' => 'Tên đơn hàng',
            'create_at' => 'Ngày tạo đơn',
            'status' => 'Trạng thái đơn hàng'
        ]

    ],
    'attributeCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm thuộc tính',
            'table' => 'Thông tin nhóm thuộc tính',
            'create' => 'Tạo mới nhóm thuộc tính'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm thuộc tính',
            'success' => 'Tạo mới nhóm thuộc tính thành công.',
            'error' => 'Tạo mới nhóm thuộc tính thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm thuộc tính',
            'success' => 'Cập nhập nhóm thuộc tính thành công.',
            'error' => 'Cập nhập nhóm thuộc tính thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm thuộc tính thành công.',
            'error' => 'Xoá nhóm thuộc tính thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm',
            'keyword' => 'Từ khoá '
        ],

    ],

    'attribute' => [
        'index' => [
            'title' => 'Danh sách thuộc tính',
            'table' => 'Thông tin thuộc tính',
            'create' => 'Tạo mới thuộc tính'
        ],
        'create' => [
            'title' => 'Tạo mới thuộc tính',
            'success' => 'Tạo mới thuộc tính thành công.',
            'error' => 'Tạo mới thuộc tính thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập thuộc tính',
            'success' => 'Cập nhập thuộc tính thành công.',
            'error' => 'Cập nhập thuộc tính thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá thuộc tính thành công.',
            'error' => 'Xoá thuộc tính thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề thuộc tính',
            'attributeCatalogue' => 'Chọn nhóm thuộc tính',
        ]
    ],

    'productCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm sản phẩm',
            'table' => 'Thông tin nhóm sản phẩm',
            'create' => 'Tạo mới nhóm sản phẩm'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm sản phẩm',
            'success' => 'Tạo mới nhóm sản phẩm thành công.',
            'error' => 'Tạo mới nhóm sản phẩm thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm sản phẩm',
            'success' => 'Cập nhập nhóm sản phẩm thành công.',
            'error' => 'Cập nhập nhóm sản phẩm thất bại.',
        ],
        'delete' => [
            'title' => 'Cập nhập nhóm sản phẩm',
            'success' => 'Xoá nhóm sản phẩm thành công.',
            'error' => 'Xoá nhóm sản phẩm thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm',

        ]
    ],
    'product' => [
        'index' => [
            'title' => 'Danh sách sản phẩm',
            'table' => 'Thông tin sản phẩm',
            'create' => 'Tạo mới sản phẩm'
        ],
        'create' => [
            'title' => 'Tạo mới sản phẩm',
            'success' => 'Tạo mới sản phẩm thành công.',
            'error' => 'Tạo mới sản phẩm thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập sản phẩm',
            'success' => 'Cập nhập sản phẩm thành công.',
            'error' => 'Cập nhập sản phẩm thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá sản phẩm thành công.',
            'error' => 'Xoá sản phẩm thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề sản phẩm',
            'productCatalogue' => 'Chọn nhóm sản phẩm',
        ]
    ],
    'postCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm bài viết',
            'table' => 'Thông tin nhóm bài viết',
            'create' => 'Tạo mới nhóm bài viết'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm bài viết',
            'success' => 'Tạo mới nhóm bài viết thành công.',
            'error' => 'Tạo mới nhóm bài viết thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm bài viết',
            'success' => 'Cập nhập nhóm bài viết thành công.',
            'error' => 'Cập nhập nhóm bài viết thất bại.',
        ],
        'delete' => [
            'title' => 'Cập nhập nhóm bài viết',
            'success' => 'Xoá nhóm bài viết thành công.',
            'error' => 'Xoá nhóm bài viết thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm',
        ]
    ],
    'post' => [
        'index' => [
            'title' => 'Danh sách bài viết',
            'table' => 'Thông tin bài viết',
            'create' => 'Tạo mới bài viết'
        ],
        'create' => [
            'title' => 'Tạo mới bài viết',
            'success' => 'Tạo mới bài viết thành công.',
            'error' => 'Tạo mới bài viết thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập bài viết',
            'success' => 'Cập nhập bài viết thành công.',
            'error' => 'Cập nhập bài viết thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá bài viết thành công.',
            'error' => 'Xoá bài viết thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề bài viết',
            'postCatalogue' => 'Chọn nhóm bài viết',
        ]
    ],
    'userCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm thành viên',
            'table' => 'Thông tin nhóm thành viên',
            'create' => 'Tạo mới nhóm thành viên'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm thành viên',
            'success' => 'Tạo mới nhóm thành viên thành công.',
            'error' => 'Tạo mới nhóm thành viên thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm thành viên',
            'success' => 'Cập nhập nhóm thành viên thành công.',
            'error' => 'Cập nhập nhóm thành viên thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm thành viên thành công.',
            'error' => 'Xoá nhóm thành viên thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm thành viên',
            'countUser' => 'Số thành viên'
        ],
        'permission' => [
            'title' => 'Cập nhập quyền',
            'success' => 'Cập nhập quyền thành công.',
            'error' => 'Cập nhập quyền thất bại.',
        ]
    ],
    'user' => [
        'index' => [
            'title' => 'Danh sách thành viên',
            'table' => 'Thông tin thành viên',
            'create' => 'Tạo mới thành viên'
        ],
        'create' => [
            'title' => 'Tạo mới thành viên',
            'success' => 'Tạo mới thành viên thành công.',
            'error' => 'Tạo mới thành viên thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập thành viên',
            'success' => 'Cập nhập thành viên thành công.',
            'error' => 'Cập nhập thành viên thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá thành viên thành công.',
            'error' => 'Xoá thành viên thất bại.',
        ],
        'table' => [
            'name' => 'Tên thành viên',
            'userGroup' => 'Nhóm thành viên',
            'userGroupSelect' => 'Chọn nhóm thành viên',
        ]
    ],
    'customerCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm khách hàng',
            'table' => 'Thông tin nhóm khách hàng',
            'create' => 'Tạo mới nhóm khách hàng'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm khách hàng',
            'success' => 'Tạo mới nhóm khách hàng thành công.',
            'error' => 'Tạo mới nhóm khách hàng thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm khách hàng',
            'success' => 'Cập nhập nhóm khách hàng thành công.',
            'error' => 'Cập nhập nhóm khách hàng thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm khách hàng thành công.',
            'error' => 'Xoá nhóm khách hàng thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm khách hàng',
            'countUser' => 'Số khách hàng'
        ],

    ],
    'customer' => [
        'index' => [
            'title' => 'Danh sách khách hàng',
            'table' => 'Thông tin khách hàng',
            'create' => 'Tạo mới khách hàng'
        ],
        'create' => [
            'title' => 'Tạo mới khách hàng',
            'success' => 'Tạo mới khách hàng thành công.',
            'error' => 'Tạo mới khách hàng thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập khách hàng',
            'success' => 'Cập nhập khách hàng thành công.',
            'error' => 'Cập nhập khách hàng thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá khách hàng thành công.',
            'error' => 'Xoá khách hàng thất bại.',
        ],
        'table' => [
            'name' => 'Tên khách hàng',
            'customerGroup' => 'Nhóm khách hàng',
            'customerGroupSelect' => 'Chọn nhóm khách hàng',
            'sourceSelect' => 'Chọn nguồn khách hàng',
            'source' => 'Nguồn khách hàng',
        ]
    ],

    'permission' => [
        'index' => [
            'title' => 'Danh sách quyền',
            'table' => 'Thông tin quyền',
            'create' => 'Tạo mới quyền',
            'success' => 'Thay đổi quyền thành công.',
            'error' => 'Thay đổi quyền thất bại.'
        ],
        'create' => [
            'title' => 'Tạo mới quyền',
            'success' => 'Tạo mới quyền thành công.',
            'error' => 'Tạo mới quyền thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập quyền',
            'success' => 'Cập nhập quyền thành công.',
            'error' => 'Cập nhập quyền thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá quyền thành công.',
            'error' => 'Xoá quyền thất bại.',
        ],
        'table' => [
            'name' => 'Tên quyền',
        ]
    ],
    'language' => [
        'index' => [
            'title' => 'Danh sách ngôn ngữ',
            'table' => 'Thông tin ngôn ngữ',
            'create' => 'Tạo mới ngôn ngữ',
            'success' => 'Thay đổi ngôn ngữ thành công.',
            'error' => 'Thay đổi ngôn ngữ thất bại.'
        ],
        'create' => [
            'title' => 'Tạo mới ngôn ngữ',
            'success' => 'Tạo mới ngôn ngữ thành công.',
            'error' => 'Tạo mới ngôn ngữ thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập ngôn ngữ',
            'success' => 'Cập nhập ngôn ngữ thành công.',
            'error' => 'Cập nhập ngôn ngữ thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá ngôn ngữ thành công.',
            'error' => 'Xoá ngôn ngữ thất bại.',
        ],
        'table' => [
            'name' => 'Tên ngôn ngữ',
        ],
        'switch' => [
            'success' => 'Thay đổi ngôn ngữ thành công.',
            'error' => 'Thay đổi ngôn ngữ thất bại.',
        ],
        'translate' => [
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ]
    ],
    'generate' => [
        'index' => [
            'title' => 'Danh sách module',
            'table' => 'Thông tin module',
            'create' => 'Tạo mới module',
            'success' => 'Thay đổi module thành công.',
            'error' => 'Thay đổi module thất bại.'
        ],
        'create' => [
            'title' => 'Tạo mới module',
            'success' => 'Tạo mới module thành công.',
            'error' => 'Tạo mới module thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập module',
            'success' => 'Cập nhập module thành công.',
            'error' => 'Cập nhập module thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá module thành công.',
            'error' => 'Xoá module thất bại.',
        ],
        'table' => [
            'name' => 'Tên model',
            'module' => 'Tên chức năng',
            'path' => 'Đường dẫn'
        ]
    ],
    'slide' => [
        'index' => [
            'title' => 'Danh sách slide & banner',
            'table' => 'Thông tin slide & banner',
            'create' => 'Tạo mới slide & banner'
        ],
        'create' => [
            'title' => 'Tạo mới slide & banner',
            'success' => 'Tạo mới slide & banner thành công.',
            'error' => 'Tạo mới slide & banner thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập slide & banner',
            'success' => 'Cập nhập slide & banner thành công.',
            'error' => 'Cập nhập slide & banner thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá slide & banner thành công.',
            'error' => 'Xoá slide & banner thất bại.',
        ],
        'drag' => [
            'success' => 'Cập nhập vị trí slide thành công.',
            'error' => 'Cập nhập vị trí slide thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề slide & banner',
            'attributeCatalogue' => 'Chọn nhóm slide & banner',
        ]
    ],
    'widget' => [
        'index' => [
            'title' => 'Danh sách widget',
            'table' => 'Thông tin widget',
            'create' => 'Tạo mới widget'
        ],
        'create' => [
            'title' => 'Tạo mới widget',
            'success' => 'Tạo mới widget thành công.',
            'error' => 'Tạo mới widget thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập widget',
            'success' => 'Cập nhập widget thành công.',
            'error' => 'Cập nhập widget thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá widget thành công.',
            'error' => 'Xoá widget thất bại.',
        ],
        'translate' => [
            'title' => 'Tạo bản dịch cho widget',
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ],
        'table' => [
            'name' => 'Tên widget',
        ]
    ],
    'promotion' => [
        'index' => [
            'title' => 'Danh sách khuyến mãi',
            'table' => 'Thông tin khuyến mãi',
            'create' => 'Tạo mới khuyến mãi'
        ],
        'create' => [
            'title' => 'Tạo mới khuyến mãi',
            'success' => 'Tạo mới khuyến mãi thành công.',
            'error' => 'Tạo mới khuyến mãi thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập khuyến mãi',
            'success' => 'Cập nhập khuyến mãi thành công.',
            'error' => 'Cập nhập khuyến mãi thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá khuyến mãi thành công.',
            'error' => 'Xoá khuyến mãi thất bại.',
        ],
        'translate' => [
            'title' => 'Tạo bản dịch cho khuyến mãi',
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ],
        'table' => [
            'name' => 'Tên chương trình',
            'code' => 'Mã khuyến mãi',
            'discount' => 'Chiết khấu',
            'promotionType' => 'Chọn hình thức khuyến mãi',
            'promotionMethod' => 'Loại khuyến mãi',
        ]
    ],
    'source' => [
        'index' => [
            'title' => 'Danh sách nguồn khách',
            'table' => 'Thông tin nguồn khách',
            'create' => 'Tạo mới nguồn khách'
        ],
        'create' => [
            'title' => 'Tạo mới nguồn khách',
            'success' => 'Tạo mới nguồn khách thành công.',
            'error' => 'Tạo mới nguồn khách thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nguồn khách',
            'success' => 'Cập nhập nguồn khách thành công.',
            'error' => 'Cập nhập nguồn khách thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nguồn khách thành công.',
            'error' => 'Xoá nguồn khách thất bại.',
        ],
        'translate' => [
            'title' => 'Tạo bản dịch cho nguồn khách',
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ],
        'table' => [
            'name' => 'Tên nguồn khách',
        ]
    ],
    'comment' => [
        'index' => [
            'title' => 'Danh sách đánh giá',
            'table' => 'Thông tin đánh giá',
            'create' => 'Tạo mới đánh giá'
        ],
        'table' => [
            'fullname' => 'Người đánh giá',
            'created_at' => 'Ngày đánh giá',
            'star' => 'Số sao'
        ]
    ],
    'code' => "Mã",
    'rating' => "Đánh giá",
    'updateBtn' => "Cập nhập",
    'customerInfo' => "Khách hàng",
    'payment' => "Thanh toán",
    'paymentMethod' => "Hình thức",
    'shipping' => "Phí ship",
    'delivery' => "Giao hàng",
    'endTotal' => "Tổng cuối",
    'discount' => "Giảm giá",
    'expired' => "Hết hạn",
    'selectModule' => 'Chọn module',
    'infomation' => 'Thông tin',
    'infoDetail' => 'Thông tin chi tiết',
    'timeApplication' => 'Thời gian áp dụng chương trình',
    'applicableCustomer' => 'Nguồn khách áp dụng',
    'applicableObject' => 'Đối tượng áp dụng',
    'noStoppingDay' => 'Không ngày kết thúc',
    'startDate' => 'Thời gian bắt đầu',
    'endDate' => 'Thời gian kết thúc',
    'contentConfiguration' => 'Cấu hình nội dung',
    'errorChildDelete' => 'Không thể xoá do vẫn còn danh mục con.',
    'parentId' => 'Danh mục cha',
    'catalogueSub' => 'Danh mục phụ',
    'permissionName' => 'Phân quyền',
    'parentIdNotice' => 'Chọn [Root] nếu không có danh mục cha',
    'image' => 'Chọn ảnh đại diện',
    'advance' => 'Cấu hình nâng cao',
    'basic' => 'Cấu hình cơ bản',
    'width' => 'Chiều rộng',
    'effect' => 'Hiệu ứng',
    'runAuto' => 'Tự động chạy',
    'openNewTab' => 'Mở trong tab mới',
    'notSlideYet' => 'Chưa có hình ảnh được chọn...',
    'stopOnHover' => 'Dừng khi di chuột',
    'changeScene' => 'Chuyển cảnh',
    'effectSpeed' => 'Tốc độ hiệu ứng',
    'arrow' => 'Mũi tên',
    'height' => 'Chiều cao',
    'status' => 'Trạng thái',
    'slideList' => 'Danh sách slides',
    'on' => 'Bật',
    'off' => 'Tắt',
    'publish' => 'Tình trạng',
    'follow' => 'Điều hướng',
    'noteNotice' => ['Lưu ý:', 'là các trường bắt buộc'],
    'generalInfomation' => 'Thông tin chung',
    'perpage' => 'bản ghi',
    'keywordPlaceholder' => 'Tìm kiếm',
    'name' => 'Tiêu đề',
    'description' => 'Mô tả',
    'content' => 'Nội dung',
    'uploadMultipleImage' => 'Tải lên nhiều ảnh',
    'seo' => [
        'info' => 'Cấu hình SEO',
        'title' => 'Tiêu đề SEO',
        'keyword' => 'Từ khoá SEO',
        'description' => 'Mô tả SEO',
        'canonical' => 'Đường dẫn',
    ],
    'slideName' => 'Tên Slide',
    'searchHere' => 'Tìm kiếm ở đây...',
    'addSlide' => 'Thêm slide',
    'keyword' => 'Từ khoá',
    'seoExample' => ['duong-dan-cua-ban', 'Bạn chưa nhập tiêu đề', 'Bạn
    chưa nhập mô tả'],
    'album' => 'Chọn ảnh album',
    'email' => 'Email',
    'phone' => 'Số điện thoại',
    'fullname' => 'Họ và tên',
    'birthday' => 'Ngày sinh',
    'created' => 'Ngày tạo',
    'password' => 'Mật khẩu',
    'rePassword' => 'Nhập lại mật khẩu',
    'cities' => 'Tỉnh/Thành phố',
    'districts' => 'Quận/Huyện',
    'wards' => 'Phường/Xã',
    'address' => 'Địa chỉ',
    'notes' => 'Ghi chú',
    'canonical' => 'Canonical',
    'contactInfo' => 'Thông tin liên hệ',
    'albumNotice' => 'Sử dụng nút chọn ảnh hoặc chọn vào đây để thêm hình ảnh.',
    'tableStatus' => 'Tình trạng',
    'tableAction' => 'Thực thi',
    'tableOrder' => 'Vị trí',
    'tableDescription' => 'Mô tả',
    'tablePhone' => 'Số điện thoại',
    'tableEmail' => 'Email',
    'tableAddress' => 'Địa chị',
    'tableCanonical' => 'Canonical',
    'person' => 'người',
    'creator' => 'người tạo',
    'publishAll' => 'Xuất bản toàn bộ',
    'unpublishAll' => 'Huỷ xuất bản toàn bộ',
    'tableDisplayGroup' => 'Nhóm hiển thị',
    'deleteModalTitle' => 'Bạn có chắc không! Muốn xóa bản ghi này?',
    'deleteModalDescription' => 'Bạn có thực sự muốn xóa những bản ghi này? Bạn không thể khôi phục bản ghi trong danh sách của mình nữa nếu bạn xóa!',
    'cancelButton' => 'Huỷ bỏ',
    'agreeButton' => 'Đồng ý',
    'saveButton' => 'Lưu lại',


];
