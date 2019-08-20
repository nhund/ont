# onthiez

##laravel framework  ver 5.4 
các bước cài đặt :
 Yêu cầu : PHP >= 5.6.4 

không tải code về và sửa các thông tin trong file config/database.php . source vẫn code file .env những ko dùng vì trước ko biết sẽ chạy trên host hay vps . nên sửa đê ko cần chỏ document root vào public. tất cả config sẽ sửa vào các file trong config.

Tạo database : 
1. run composer update
2. php artisan config:cache 
3. composer dump
4. php artisan migrate

hoặc import file sql có sẵn data ở đây : database/onthiez_lopcuatoi_27_03_19.sql 



