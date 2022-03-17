
## Install:
- Clone this project (Clone project từ git về htdocs trong xampp)
- import database
- Run composer install or composer update (Tạo folder vender)
- Create .env file : cp .env.example .env (tạo ra file .env để cấu hình Database)
- Generate app key : php artisan key:generate (Sinh key chạy Laravel)
- Migrate database: php artisan migrate (Tạo database)
- Seed database: php artisan db:seed (Tạo dữ liệu có sẵn)
- Run: php artisan storage:link (Tạo Storage ra thư mục pubic)
- Open up web server: php artisan serve (Chạy server)
- Browse app: localhost:8000 or http://127.0.0.1:8000
- demo: https://drive.google.com/file/d/1Kcj0dBiGWXr1PpS8i-DsUL3wrDUzafxv/view?usp=sharing
- link website: https://challenge5b-tuantv.000webhostapp.com/
