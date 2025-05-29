<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index(Request $request, Student $student)
    {
        $sort = $request->query('sort', '');
        $filter = $request->query('filter', '');
        // Lấy giá trị tham số sort trong URL.
        $scores = $student->scores()->with('subject')
            // Lấy tất cả điểm của sinh viên, đồng thời load cả thông tin môn học liên quan.
            ->when($sort === 'score_desc', function ($query) {
                return $query->orderBy('score', 'desc');
            })
            ->when($sort === 'score_asc', function ($query) {
                return $query->orderBy('score', 'asc');
            })

            ->when($filter === 'fail', function ($query) {
                return $query->where('score', '<', 4);
            })
            // nếu là fail chỉ lấy môn dưới 4 
            ->get();
        // thực thi truy vấn lấy danh sách điểm 

        return view('students.scores.index', compact('student', 'scores', 'sort', 'filter'));
    }
    public function create(Student $student)
    {
        $subjectIdsWithScore = $student->scores()->pluck('subject_id');
        // Lấy danh sách các môn mà sinh viên này đã có điểm → để tránh thêm trùng.
        $subjects = Subject::whereNotIn('id', $subjectIdsWithScore)->get();
        //  Lấy danh sách các môn học chưa có điểm để chọn khi thêm.
        return view('students.scores.create', compact('student', 'subjects'));
    }

    public function store(Request $request, Student $student)
    {
        $subject = Subject::find($request->subject_id);
        // Tìm môn học theo subject_id.
        if (!$subject) {
            return redirect()->back()->with('error', 'Môn học không tồn tại');
        }
        $existingScore = $student->scores()->where('subject_id', $request->subject_id)->first();
        if ($existingScore) {
            return redirect()->back()->with('error', 'Môn học này đã có điểm, không thể thêm lại!');
            //  Nếu sinh viên đã có điểm môn này thì không cho thêm nữa
        }
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:10',
        ]);
        // kiểm tra đầu vào 
        $student->scores()->create([
            'subject_id' => $request->subject_id,
            'score' => $request->score,
        ]);
        // thêm vào database 
        return redirect()->route('students.scores.index', $student->id)->with('success', 'Thêm điểm thành công');
    }

    public function edit(Student $student, Score $score)
    {
        return view('students.scores.edit', compact('student', 'score'));
    }

    public function update(Request $request, Student $student, Score $score)
    {

        $request->validate([
            'score' => 'required|numeric|min:0|max:10',
        ]);
        // kiểm tra đầu vào 
        $score->update([
            'score' => $request->score,
        ]);
        // Cập nhật điểm trong cơ sở dữ liệu
        return redirect()->route('students.scores.index', $student->id)->with('success', 'Cập nhật điểm thành công');
    }

    public function destroy(Student $student, Score $score)
    {

        $score->delete();
        // Xóa bản ghi điểm khỏi database.
        return redirect()->route('students.scores.index', $student->id)->with('success', 'Xóa điểm thành công');
    }
}
