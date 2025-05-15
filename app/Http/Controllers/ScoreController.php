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

        $scores = $student->scores()->with('subject')
            ->when($sort === 'score_desc', function ($query) {
                return $query->orderBy('score', 'desc');
            })
            ->when($sort === 'score_asc', function ($query) {
                return $query->orderBy('score', 'asc');
            })

            ->when($filter === 'fail', function ($query) {
                return $query->where('score', '<', 4);
            })
            ->get();

        return view('students.scores.index', compact('student', 'scores', 'sort', 'filter'));
    }
    public function create(Student $student)
    {
        $subjectIdsWithScore = $student->scores()->pluck('subject_id');

        $subjects = Subject::whereNotIn('id', $subjectIdsWithScore)->get();

        return view('students.scores.create', compact('student', 'subjects'));
    }

    public function store(Request $request, Student $student)
    {
        $subject = Subject::find($request->subject_id);
        if (!$subject) {
            return redirect()->back()->with('error', 'Môn học không tồn tại');
        }

        $existingScore = $student->scores()->where('subject_id', $request->subject_id)->first();
        if ($existingScore) {
            return redirect()->back()->with('error', 'Môn học này đã có điểm, không thể thêm lại!');
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:10',
        ]);

        $student->scores()->create([
            'subject_id' => $request->subject_id,
            'score' => $request->score,
        ]);

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


        $score->update([
            'score' => $request->score,
        ]);

        return redirect()->route('students.scores.index', $student->id)->with('success', 'Cập nhật điểm thành công');
    }

    public function destroy(Student $student, Score $score)
    {

        $score->delete();
        return redirect()->route('students.scores.index', $student->id)->with('success', 'Xóa điểm thành công');
    }
}
