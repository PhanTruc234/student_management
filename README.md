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

| Tên cột    | Kiểu dữ liệu   | Ghi chú                                        |
|-----------|----------------|------------------------------------------------|
| id        | BIGINT         | Khóa chính                                     |
| student_id| FOREIGN (BIGINT)| Liên kết đến bảng `students`                   |
| subject_id| FOREIGN (BIGINT)| Liên kết đến bảng `subjects`                   |
| score     | DECIMAL(5,2)   | Điểm số (vd: 7.50, 9.25)                       |

---

### attendances – Điểm danh

| Tên cột         | Kiểu dữ liệu    | Ghi chú                                       |
|-----------------|-----------------|-----------------------------------------------|
| id              | BIGINT          | Khóa chính                                    |
| student_id      | FOREIGN (BIGINT)| FK đến `students`                             |
| subject_id      | FOREIGN (BIGINT)| FK đến `subjects`                             |
| absent_sessions | INTEGER         | Số buổi vắng học của sinh viên trong môn đó   |
