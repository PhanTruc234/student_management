# Hệ thống Quản lý Sinh viên

## 🚀 Giới thiệu

Hệ thống giúp quản lý toàn diện thông tin sinh viên, môn học, điểm số và điểm danh. Được xây dựng theo mô hình **MVC của Laravel**, dễ mở rộng và bảo trì.

---

## 🔧 Các chức năng chính

| Module    | Chức năng                                                                 |
|-----------|-------------------------------------------------------------------------- |
| **Sinh viên**  | - Thêm, sửa, xóa sinh viên<br>- Tìm kiếm sinh viên theo tên, mã, email |
| **Môn học**    | - Thêm, sửa, xóa môn học                                              |
| **Điểm số**    | - Nhập, sửa điểm sinh viên theo từng môn<br>- Tính điểm tổng kết     |
| **Điểm danh**  | - Ghi nhận số buổi vắng chi tiết theo từng buổi học                  |

---

## 🧩 Mô hình cơ sở dữ liệu

### `students`

| Cột     | Kiểu dữ liệu  | Ghi chú              |
|---------|---------------|----------------------|
| id      | BIGINT        | Khóa chính           |
| code    | VARCHAR(10)   | Mã sinh viên, duy nhất|
| name    | VARCHAR       | Họ tên sinh viên     |
| email   | VARCHAR       | Email, duy nhất      |
| gender  | VARCHAR       | Giới tính            |
| dob     | DATE          | Ngày sinh            |

### `subjects`

| Cột     | Kiểu dữ liệu | Ghi chú               |
|---------|--------------|-----------------------|
| id      | BIGINT       | Khóa chính            |
| code    | VARCHAR      | Mã môn học, duy nhất  |
| name    | VARCHAR      | Tên môn học           |
| credit  | INT          | Số tín chỉ (thêm mới) |
| total_sessions | INT   | Tổng số buổi học      |

### `scores`

| Cột       | Kiểu dữ liệu  | Ghi chú                                |
|-----------|----------------|----------------------------------------|
| id        | BIGINT         | Khóa chính                            |
| student_id| FOREIGN (BIGINT)| Liên kết đến `students`               |
| subject_id| FOREIGN (BIGINT)| Liên kết đến `subjects`               |
| cc1       | FLOAT          | Chuyên cần từ điểm danh               |
| cc2       | FLOAT          | Chuyên cần nhập tay                   |
| midterm   | FLOAT          | Giữa kỳ                               |
| final     | FLOAT          | Cuối kỳ                               |
| score     | FLOAT          | Điểm tổng kết (calculated)            |

### `attendances`

| Cột             | Kiểu dữ liệu     | Ghi chú                                  |
|-----------------|------------------|------------------------------------------|
| id              | BIGINT           | Khóa chính                               |
| student_id      | FOREIGN (BIGINT) | FK đến `students`                        |
| subject_id      | FOREIGN (BIGINT) | FK đến `subjects`                        |
| absent_sessions | INT              | Số buổi vắng (tính từ `session_details`)|
| session_details | JSON             | Lưu mảng trạng thái điểm danh (true/false)|

---

## 🔄 Logic Tính Điểm & Học Lại

- **cc1 = max(0, 10 - số buổi vắng * 3)**
- Nếu `số buổi vắng > 3` → Học lại môn
- **Điểm tổng kết =** `cc1 * 0.05 + cc2 * 0.05 + midterm * 0.3 + final * 0.6`

---

## 🔌 API Endpoints

Tất cả API trả về JSON.

### 📘 SubjectApiController

| Phương thức | Endpoint           | Mô tả                    |
|-------------|--------------------|---------------------------|
| GET         | /api/subjects      | Lấy danh sách môn học    |
| POST        | /api/subjects      | Tạo mới môn học          |
| PUT         | /api/subjects/{id} | Cập nhật môn học         |
| DELETE      | /api/subjects/{id} | Xóa môn học              |

---

### 👨‍🎓 StudentApiController

| Phương thức | Endpoint           | Mô tả                                          |
|-------------|--------------------|------------------------------------------------|
| GET         | /api/students      | Danh sách sinh viên (search, sort)            |
| POST        | /api/students      | Thêm sinh viên mới                            |
| PUT         | /api/students/{id} | Cập nhật thông tin sinh viên                  |
| DELETE      | /api/students/{id} | Xóa sinh viên                                  |

---

### 📝 ScoreApiController

| Phương thức | Endpoint                            | Mô tả                      |
|-------------|--------------------------------------|-----------------------------|
| GET         | /students/{id}/scores               | Danh sách điểm theo sinh viên |
| POST        | /students/{id}/scores               | Gán điểm                    |
| PUT         | /scores/{id}                        | Cập nhật điểm              |
| DELETE      | /scores/{id}                        | Xóa điểm                   |

---

### ⏰ AttendanceApiController

| Phương thức | Endpoint                               | Mô tả                            |
|-------------|-----------------------------------------|-----------------------------------|
| GET         | /students/{id}/attendances             | Xem điểm danh                    |
| POST        | /students/{id}/attendances             | Ghi nhận điểm danh               |
| PUT         | /attendances/{id}                      | Cập nhật số buổi vắng            |
| DELETE      | /attendances/{id}                      | Xóa ghi nhận                     |

---

## 🔒 Xác thực & Phân quyền

- **Admin**: Có quyền truy cập và chỉnh sửa toàn bộ dữ liệu.
- **Người dùng thông thường**: Truy cập dashboard và profile cá nhân.

---

## 🗂️ Cấu trúc Route chính

### `web.php` (giao diện web)

- `/students`, `/subjects`, `/students/{id}/scores`, `/students/{id}/attendances`, ...
- `/dashboard`, `/profile`, ...

### `api.php` (RESTful API)

- `/api/students`, `/api/subjects`, `/api/scores`, `/api/attendances`, ...

---

## 📘 Ghi chú

- **Sử dụng CSDL `mysql_aiven`** cho toàn bộ các model.
- Dữ liệu điểm danh chi tiết lưu trong `JSON` để theo dõi từng buổi học.
- Hệ thống hỗ trợ cả **giao diện web** và **API** phục vụ frontend/mobile.
