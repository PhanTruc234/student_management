<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;

class SubjectController extends Controller
{
    public function index(Request $request, Student $student)
    {
        $search = $request->query('search');

        $subjects = Subject::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('subjects.index', compact('subjects', 'student'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
            // bắt buộc, là chuỗi, tối đa 255 ký tự, và không trùng tên môn học đã có.
            'credit' => 'required|integer|min:1'
        ]);
        $subjectCode = 'PKA' . str_pad(Subject::count() + 1, 3, '0', STR_PAD_LEFT);
        Subject::create([
            'code' => $subjectCode,
            'name' => $request->name,
            'credit' => $request->credit,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Môn học đã được thêm');
    }

    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'credit' => 'required|integer|min:1',
        ]);

        $subject->update([
            'name' => $request->name,
            'credit' => $request->credit,
        ]);
        return redirect()->route('subjects.index')->with('success', 'Môn học đã được cập nhật');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Môn học đã được xóa');
    }
}
