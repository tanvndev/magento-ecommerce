<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm yêu thích của bạn</title>
</head>
<body>
    <h1>Xin chào {{ $user->fullname }},</h1>
    <p>Chúng tôi nhận thấy bạn đã quan tâm đến một số sản phẩm tuyệt vời trên THHĐShop. Dưới đây là 5 sản phẩm yêu thích mà bạn đã chọn. Hãy nhanh tay đặt hàng trước khi hết hàng!</p>

    <h3>Sản phẩm yêu thích của bạn:</h3>
    <ul>
        @foreach ($data as $item)
            <li>
                <strong>{{ $item->product_variant->name }}</strong> - Giá: {{ number_format($item->product_variant->price, 0, ',', '.') }} VND
                <br>
                <a href="#">Xem chi tiết</a>
            </li>
        @endforeach
    </ul>

    <p>Chúng tôi đang có nhiều ưu đãi hấp dẫn dành riêng cho bạn. Hãy đặt hàng ngay và nhận ưu đãi giảm giá đặc biệt!</p>

    <p><strong>Mã giảm giá độc quyền:</strong> SAVE10</p>
    <p>Sử dụng mã <strong>SAVE10</strong> để nhận được giảm giá 10% khi mua bất kỳ sản phẩm nào từ danh sách yêu thích của bạn.</p>

    <p>Chúng tôi rất trân trọng sự quan tâm của bạn và mong được phục vụ bạn sớm!</p>

    <p>Trân trọng,<br>
    Đội ngũ WD-59</p>
</body>
</html>