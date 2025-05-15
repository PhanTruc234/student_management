@extends('master')

@section('title', 'Thêm điểm danh')

@section('content')
    <h3>Thêm điểm danh cho sinh viên: {{ $student->name }}</h3>

    <form action="{{ route('students.attendances.store', $student->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subject_id" class="form-label">Môn học</label>
            <select name="subject_id" id="subject_id" class="form-control" required>
                <option value="">-- Chọn môn học --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="absent_sessions" class="form-label">Số buổi vắng</label>
            <input type="number" name="absent_sessions" class="form-control" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('students.attendances.index', $student->id) }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
