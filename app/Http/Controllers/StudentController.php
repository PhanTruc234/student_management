<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // Lấy giá trị search và sort từ URL query
        $sort = $request->query('sort', 'name');
        // Nếu không có sort thì mặc định là 'name'
        $students = Student::query()
            ->leftJoin('scores', 'students.id', '=', 'scores.student_id')
            // leftJoin với bảng scores theo student_id để tính điểm trung bình.
            ->groupBy('students.id', 'students.code', 'students.name', 'students.email', 'students.gender', 'students.dob', 'students.created_at', 'students.updated_at')
            ->select(
                'students.*',
                DB::raw('AVG(scores.score) as average_score')
            )
            // Chọn tất cả các trường của sinh viên, và thêm trường average_score (trung bình điểm) từ bảng scores.
            ->when($search, function ($query, $search) {
                return $query->where('students.name', 'like', "%{$search}%");
            });
        // Nếu có từ khóa tìm kiếm ($search), lọc sinh viên theo tên chứa từ đó (LIKE '%%').
        if ($sort === 'name_desc') {
            $students = $students->orderBy('students.name', 'desc'); // sắp xếp tên sinh viên
        } elseif ($sort === 'average_score_desc') {
            $students = $students->orderBy('average_score', 'desc');
            // sắp xếp điểm 
        } else {
            $students = $students->orderBy('students.name', 'asc');  // Mặc định sắp xếp theo tên A-Z
        }

        $students = $students->paginate(10);

        return view('students.index', [ // trả về danh sách sinh viên
            'students' => $students,
            'sort' => $sort,
            'search' => $search
        ]);
    }
    public function create()
    {
        return view('students.create');
    }
    public function store(Request  $request)
    {
        $lastStudent = Student::latest('id')->first();
        $nextId = $lastStudent ? $lastStudent->id + 1 : 1;
        $studentCode = 'PMT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        // lấy sinh viên có id mới nhất tạo mã sinh viên tiếp theo
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date',
        ]);
        //  Kiểm tra dữ liệu đầu vào. Nếu sai sẽ tự động redirect lại với lỗi
        // Tạo mới student
        Student::create([
            'code' => $studentCode,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);
        // Lưu sinh viên mới vào database
        return redirect()->route('students.index')->with('success', 'Thêm thành công');
    }
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }
    public function update(Request  $request, Student $student)
    {
        $student->update([
            'code' => $request->student_code,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);
        // Cập nhật thông tin sinh viên trong DB
        return redirect()->route('students.index')->with('success', 'Cập nhật thành công');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        // xóa sinh viên 
        DB::statement('ALTER TABLE students AUTO_INCREMENT = 1');
        return back()->with('success', 'Xóa thành công');
        //  Quay lại trang trước với thông báo xóa thành công.
    }
}