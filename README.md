# Portfolio Personal (PHP Edition)

Ứng dụng này chuyển đổi portfolio tĩnh ban đầu thành website PHP + MySQL với đầy đủ chức năng quản trị dự án và lưu trữ liên hệ.

## Tính năng chính

- Giao diện HTML/CSS gốc được giữ nguyên.
- Trang chủ hiển thị danh sách dự án từ cơ sở dữ liệu (có thẻ dự phòng khi chưa có dữ liệu).
- Form liên hệ sử dụng CSRF token, lưu tin nhắn vào bảng `messages` và hiển thị thông báo phản hồi.
- Khu vực quản trị với đăng nhập, bảng điều khiển thống kê, cùng CRUD dự án.
- Không chứa tệp nhị phân; đường dẫn ảnh được nhập dưới dạng văn bản hoặc dùng placeholder.

## Yêu cầu hệ thống

- PHP 8.1+
- MySQL 5.7+/MariaDB 10+
- Composer (tùy chọn nếu cần cài thêm thư viện trong tương lai)
- Môi trường web server (Apache/Nginx) hoặc PHP built-in server

## Hướng dẫn cài đặt

1. **Sao chép mã nguồn**
   ```bash
   git clone https://github.com/nguoidung/portfolio-persional.git
   cd portfolio-persional
   ```

2. **Tạo file cấu hình**
   - Sao chép `.env.example` thành `.env` và cập nhật thông tin kết nối database:
     ```bash
     cp .env.example .env
     ```

3. **Khởi tạo cơ sở dữ liệu**
   - Tạo database trống (ví dụ `portfolio`).
   - Import file `database/schema.sql` vào database vừa tạo:
     ```bash
     mysql -u root -p portfolio < database/schema.sql
     ```

4. **Thiết lập người dùng quản trị**
   - Thêm tài khoản vào bảng `users` với mật khẩu mã hóa `password_hash` (dùng PHP CLI hoặc công cụ DB):
     ```php
     <?php echo password_hash('matkhau_bat_ky', PASSWORD_DEFAULT); ?>
     ```
   - Chèn giá trị trả về vào cột `password_hash` của user mong muốn.

5. **Chạy dự án**
   - Sử dụng PHP built-in server (phù hợp môi trường phát triển):
     ```bash
     php -S localhost:8000
     ```
   - Hoặc cấu hình trên XAMPP/LAMP/LEMP tùy môi trường.

6. **Thêm nội dung**
   - Đăng nhập trang quản trị tại `http://localhost:8000/admin/login.php`.
   - Sử dụng chức năng tạo/sửa/xóa dự án để cập nhật nội dung hiển thị ở trang chủ.
   - Form liên hệ lưu tin nhắn vào bảng `messages` để theo dõi trong dashboard.

## Ghi chú

- Thư mục `uploads/` rỗng và chỉ chứa `.gitkeep`. Khi triển khai thực tế, tải ảnh thủ công vào đây hoặc sử dụng URL bên ngoài. Không commit tệp nhị phân vào repo.
- Các liên kết ảnh mặc định dùng placeholder `https://placehold.co/600x400?text=Project+Image` khi cơ sở dữ liệu chưa có giá trị.
- Nếu cần thêm middleware hoặc chức năng mới, hãy đặt logic PHP trong thư mục `includes/` để tái sử dụng.

## Kiểm thử

- Đảm bảo import schema và cấu hình `.env` trước khi chạy.
- Đăng nhập admin để xác nhận được phép tạo/sửa/xóa dự án.
- Gửi form liên hệ và kiểm tra mục "Tin nhắn gần đây" trên dashboard.

## Bản quyền

Dự án được phát triển phục vụ mục đích học tập và giới thiệu cá nhân. Bạn có thể tùy chỉnh để phù hợp với nhu cầu riêng nhưng vui lòng không commit thêm tệp nhị phân vào kho mã.
