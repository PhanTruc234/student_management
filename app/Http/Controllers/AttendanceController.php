<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Subject;

class AttendanceController extends Controller
{
    public function index(Request $request, Student $student)
    {
        $filter = $request->query('filter', '');
        $attendances = Attendance::where('student_id', $student->id)
            ->with('subject')
            ->when($filter === 'fail', function ($query) {
                return $query->where('absent_sessions', '>=', 3);
            })
            ->get()
            ->sortBy(function ($attendance) {
                return $attendance->subject->name;
            });

        return view('attendances.index', compact('attendances', 'student', 'filter'));
    }
    public function create(Student $student)
    {
        $subjects = Subject::whereNotIn('id', function ($query) use ($student) {
            $query->select('subject_id')
                ->from('attendances')
                ->where('student_id', $student->id);
        })->get();
        // lọc nhưnng môn mà học sinh chưa điểm danhdanh

        return view('attendances.create', compact('student', 'subjects'));
    }
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'absent_sessions' => 'required|integer|min:0',
        ]);

        Attendance::create([
            'student_id' => $student->id,
            'subject_id' => $request->subject_id,
            'absent_sessions' => $request->absent_sessions,
        ]);

        return redirect()->route('students.attendances.index', $student->id)->with('success', 'Đã thêm điểm danh.');
    }
    public function edit(Attendance $attendance)
    {
        return view('attendances.edit', compact('attendance'));
    }
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'absent_sessions' => 'required|integer|min:0',
        ]);

        $attendance->update([
            'absent_sessions' => $request->absent_sessions,
        ]);

        return redirect()->route('students.attendances.index', $attendance->student_id)->with('success', 'Cập nhật thành công.');
    }
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('success', 'Đã xóa điểm danh.');
    }
}
