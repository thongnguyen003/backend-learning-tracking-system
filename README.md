# Learning Tracking System (Laravel) – Dự án học tập ở trường

## 1. Giới thiệu
Đây là dự án **Laravel** phục vụ cho mục đích **học tập tại trường**, với chức năng chính là **theo dõi tình hình học tập của sinh viên** (Learning Tracking System).

Dự án hướng đến việc thực hành:
- Xây dựng Backend theo chuẩn Laravel
- Thiết kế CSDL và quản lý dữ liệu bằng **Migration**
- Tạo dữ liệu mẫu bằng **Seeder** để hỗ trợ demo/kiểm thử
- Tổ chức cấu hình môi trường phát triển cho nhiều thành viên trong nhóm

---

## 2. Công nghệ sử dụng
- **Laravel** (PHP Framework)
- **MySQL** (Database)
- Composer (quản lý package PHP)
- (Tuỳ dự án) Node.js + npm (Vite / frontend assets)

---

## 3. Thiết lập môi trường & cấu hình `.env.dev`
Dự án có sử dụng file **`.env.dev`** để lưu trữ cấu hình dành cho môi trường phát triển, giúp các thành viên trong nhóm dễ dàng cấu hình giống nhau.

> Lưu ý:
- File `.env` là file chạy thật trên máy của bạn.
- `.env.dev` dùng làm mẫu / chia sẻ cấu hình cho thành viên khác.
- Không nên commit `.env` lên git (vì có thể chứa mật khẩu).

### Cách dùng `.env.dev`
1) Copy `.env.dev` → `.env`
```bash
copy .env.dev .env
Hoặc (Git Bash / Linux / Mac):

bash
Sao chép mã
cp .env.dev .env
Sửa lại các thông tin DB trong .env cho phù hợp máy bạn:

env
Sao chép mã
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learning_tracking
DB_USERNAME=root
DB_PASSWORD=
4. Hướng dẫn cài đặt & chạy dự án
Bước 1: Cài dependencies
bash
Sao chép mã
composer install
Bước 2: Tạo file môi trường
bash
Sao chép mã
copy .env.example .env
Nếu bạn dùng .env.dev thì copy như hướng dẫn ở mục 3.

Bước 3: Tạo APP_KEY
bash
Sao chép mã
php artisan key:generate
Bước 4: Tạo database
Tạo database trong MySQL (phpMyAdmin / Workbench), ví dụ:

learning_tracking

Bước 5: Chạy migration + seed (tạo bảng + fake dữ liệu)
Dự án có sử dụng Migration và Seed để tạo cấu trúc CSDL và fake dữ liệu phục vụ học tập/demo.

bash
Sao chép mã
php artisan migrate --seed
Nếu muốn reset toàn bộ và tạo lại từ đầu:

bash
Sao chép mã
php artisan migrate:fresh --seed
Bước 6: Chạy server
bash
Sao chép mã
php artisan serve
Truy cập:

http://127.0.0.1:8000