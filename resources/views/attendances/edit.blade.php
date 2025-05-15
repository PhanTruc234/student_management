@extends('master')

@section('title', 'Chỉnh sửa điểm danh')

@section('content')
    <h3>Sửa điểm danh của sinh viên: {{ $attendance->student->name }}</h3>
    <p>Môn học: <strong>{{ $attendance->subject->name }}</strong></p>

    <form action="{{ route('students.attendances.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="absent_sessions" class="form-label">Số buổi vắng</label>
            <input type="number" name="absent_sessions" class="form-control" min="0" value="{{ $attendance->absent_sessions }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('students.attendances.index', $attendance->student_id) }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
