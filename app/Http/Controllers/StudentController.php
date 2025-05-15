<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort', 'name');
        $students = Student::query()
            ->leftJoin('scores', 'students.id', '=', 'scores.student_id')
            ->groupBy('students.id', 'students.code', 'students.name', 'students.email', 'students.gender', 'students.dob', 'students.created_at', 'students.updated_at')
            ->select(
                'students.*',
                DB::raw('AVG(scores.score) as average_score')
            )
            ->when($search, function ($query, $search) {
                return $query->where('students.name', 'like', "%{$search}%");
            });
        if ($sort === 'name_desc') {
            $students = $students->orderBy('students.name', 'desc');
        } elseif ($sort === 'average_score_desc') {
            $students = $students->orderBy('average_score', 'desc');
        } else {
            $students = $students->orderBy('students.name', 'asc');  // Mặc định sắp xếp theo tên A-Z
        }

        $students = $students->paginate(10);

        return view('students.index', [
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
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date',
        ]);
        // Tạo mới student
        Student::create([
            'code' => $studentCode,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);

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

        return redirect()->route('students.index')->with('success', 'Cập nhật thành công');
    }
    public function destroy(Student $student)
    {
        $student->delete();
        DB::statement('ALTER TABLE students AUTO_INCREMENT = 1');
        return back()->with('success', 'Xóa thành công');
    }
}
