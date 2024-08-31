<html>
<title>Thông báo của bạn</title>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
</head>
<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
    }

    h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }

    .button {
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        text-transform: uppercase;
        border-radius: 10px;
        margin-top: 20px;
        font-weight: 600;
        cursor: pointer;
        color: white;
        transition: 0.2s ease-in-out;
    }

    .button.success {
        background-color: #9ABC66;

    }

    .button.success:hover {
        background-color: #80b347;

    }

    .button.error {
        background-color: #E74C3C;
    }

    .button.error:hover {
        background-color: #D62C1A;
    }

    .error-text {
        color: #E74C3C;
    }

    .hidden {
        display: none;
    }
</style>

<body>
    <div class="card {{ $boolean == 1 ? '' : 'hidden' }}">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">✓</i>
        </div>
        <h1>Thành công</h1>
        <p>Chúc mừng bạn đã xác nhận đăng ký thành công xin vui lòng đăng nhập tài khoản.</p>
        <a class="button success" href="{{ env('VUE_APP_URL') }}">Quay về trang chủ</a>
    </div>
    <div class="card {{ $boolean == 0 ? '' : 'hidden' }}">
        <div
            style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto; display: grid; place-items: center">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48">
                <path fill="#F44336" d="M21.5 4.5H26.501V43.5H21.5z" transform="rotate(45.001 24 24)"></path>
                <path fill="#F44336" d="M21.5 4.5H26.5V43.501H21.5z" transform="rotate(135.008 24 24)"></path>
            </svg>
        </div>
        <h1 class="error-text">Thất bại</h1>
        <p>Đường dẫn xác nhận đã hết hạn hoặc không hợp lệ vui lòng thử lại.</p>
        <a class="button error" href="{{ env('VUE_APP_URL') }}">Quay về trang chủ</a>
    </div>
</body>

</html>
