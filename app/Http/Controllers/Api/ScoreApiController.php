<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Student;

class ScoreApiController extends Controller
{
    public function index(Student $student)
    {
        $scores = $student->scores()->with('subject')->paginate(10);
        return response()->json($scores);
    }
    public function show(Score $score)
    {
        return response()->json($score->load('student', 'subject'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:10',
        ]);

        $score = Score::create($request->only('student_id', 'subject_id', 'score'));
        return response()->json(['message' => 'Điểm đã được thêm', 'score' => $score], 201);
    }

    public function update(Request $request, Score $score)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:10',
        ]);

        $score->update(['score' => $request->score]);
        return response()->json(['message' => 'Điểm đã được cập nhật', 'score' => $score]);
    }

    public function destroy(Score $score)
    {
        $score->delete();
        return response()->json(['message' => 'Điểm đã được xóa']);
    }
}
