# Hệ thống Quản lý Sinh viên
## Giới thiệu
- Quản lý **thông tin sinh viên**: mã sinh viên, họ tên, email, giới tính, ngày sinh.
- Quản lý **môn học**: tên môn, mã môn học.
- Quản lý **điểm số sinh viên** theo từng môn học.
- Ghi nhận **số buổi vắng** của sinh viên đối với từng môn học (quản lý điểm danh).

Cấu trúc rõ ràng, tách biệt các chức năng theo mô hình MVC của Laravel, giúp dễ dàng mở rộng, tái sử dụng và nâng cấp.

---

## Các chức năng chính

| Module         | Chức năng                                                                 |
|----------------|-------------------------------------------------------------------------- |
| Sinh viên      | - Thêm, sửa, xóa sinh viên<br>- Tìm kiếm sinh viên theo tên, mã, email    |
| Môn học        | - Thêm mới, chỉnh sửa, xóa môn học                                        |
| Điểm số        | - Gán điểm cho sinh viên theo từng môn<br>- Sửa và xem điểm               |
| Điểm danh      | - Ghi nhận số buổi vắng của sinh viên theo từng môn                       |

---

##  Mô hình cơ sở dữ liệu

### students – Thông tin sinh viên

| Tên cột | Kiểu dữ liệu | Ghi chú                      |
|--------|---------------|------------------------------|
| id     | BIGINT        | Khóa chính                   |
| code   | VARCHAR(10)   | Mã sinh viên, duy nhất       |
| name   | VARCHAR       | Tên sinh viên                |
| email  | VARCHAR       | Email, duy nhất              |
| gender | VARCHAR       | Giới tính (Nam/Nữ)           |
| dob    | DATE          | Ngày sinh                    |

---

### subjects – Thông tin môn học

| Tên cột | Kiểu dữ liệu | Ghi chú                      |
|--------|---------------|------------------------------|
| id     | BIGINT        | Khóa chính                   |
| code   | VARCHAR       | Mã môn học, duy nhất         |
| name   | VARCHAR       | Tên môn học                  |

---

### scores – Bảng điểm

| Tên cột    | Kiểu dữ liệu   | Ghi chú                                       |
|-----------|----------------|------------------------------------------------|
| id        | BIGINT         | Khóa chính                                     |
| student_id| FOREIGN (BIGINT)| Liên kết đến bảng `students`                  |
| subject_id| FOREIGN (BIGINT)| Liên kết đến bảng `subjects`                  |
| score     | DECIMAL(5,2)   | Điểm số                                        |

---

### attendances – Điểm danh

| Tên cột         | Kiểu dữ liệu    | Ghi chú                                       |
|-----------------|-----------------|-----------------------------------------------|
| id              | BIGINT          | Khóa chính                                    |
| student_id      | FOREIGN (BIGINT)| FK đến `students`                             |
| subject_id      | FOREIGN (BIGINT)| FK đến `subjects`                             |
| absent_sessions | INTEGER         | Số buổi vắng học của sinh viên trong môn đó   |

### API Endpoints
Tất cả các API trả về JSON.

### SubjectApiController
GET /api/subjects: Danh sách môn học (có phân trang + tìm kiếm search=)

POST /api/subjects: Thêm môn học

PUT /api/subjects/{id}: Cập nhật môn học

DELETE /api/subjects/{id}: Xóa môn học

### StudentApiController
GET /api/students: Danh sách sinh viên, cho phép:

Tìm kiếm: ?search=abc

Sắp xếp: ?sort=name_desc, ?sort=average_score_desc

POST /api/students: Thêm sinh viên mới

PUT /api/students/{id}: Cập nhật thông tin sinh viên

DELETE /api/students/{id}: Xóa sinh viên

### ScoreApiController
GET /api/students/{student}/scores: Danh sách điểm của sinh viên

GET /api/scores/{id}: Chi tiết điểm

POST /api/scores: Thêm điểm

PUT /api/scores/{id}: Cập nhật điểm

DELETE /api/scores/{id}: Xóa điểm

### AttendanceApiController
GET /api/attendances: Danh sách điểm danh (có thông tin sinh viên)

POST /api/attendances: Ghi nhận điểm danh

PUT /api/attendances/{id}: Cập nhật số buổi vắng

DELETE /api/attendances/{id}: Xóa ghi nhận điểm danh
