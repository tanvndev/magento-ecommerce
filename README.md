# Hướng dẫn Cài đặt Dự án



```bash
Di chuyển vào thư mục Vue và cài đặt các phụ thuộc:

## Bước 1: Cài đặt phụ thuộc cho Vue

cd vue
npm install

## Bước 2: Cài đặt phụ thuộc cho Laravel

cd ../laravel
composer update

## Bước 3: Cấu hình Môi trường

cd ../vue
cp .env.example .env

cd ../laravel
cp .env.example .env

## Bước 4: Khởi tạo Cơ sở dữ liệu Laravel

cd ../laravel
php artisan key:generate
php artisan migrate


## Bước 5: Khởi tạo Cơ sở dữ liệu Laravel

cd ../laravel
php artisan db:seed

## Bước 6: Khởi động Ứng dụng Vue

cd ../vue
npm run dev

* Lưu ý
>>Đảm bảo rằng các đường dẫn thư mục (`cd vue`, `cd ../laravel`, v.v.) và lệnh (`npm install`, `composer update`, v.v.) chính xác với cấu trúc dự án của bạn.<<
