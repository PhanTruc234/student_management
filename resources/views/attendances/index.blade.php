@extends('master')

@section('title', 'Quản lý điểm danh của ' . $student->name)

@section('content')
<a href="{{ route('students.index') }}" class="btn btn-secondary mb-3">← Quay lại danh sách</a>
<a href="{{ route('students.attendances.create', $student->id) }}" class="btn btn-primary mb-3">Thêm điểm danh</a>
<form action="{{ route('students.attendances.index', $student->id) }}" method="GET" class="mb-3">
    <button type="submit" name="filter" value="fail" class="btn btn-warning">Lọc môn học cần học lại</button>
    <a href="{{ route('students.attendances.index', $student->id) }}" class="btn btn-secondary">Xóa lọc</a>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Môn học</th>
            <th>Số buổi vắng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendances as $attendance)
            <tr>
                <td class="align-middle">{{ $attendance->subject->name }}</td>
                <td class="align-middle">{{ $attendance->absent_sessions }}</td>
                <td class="align-middle">
                    <a href="{{ route('students.attendances.edit', ['student' => $student->id, 'attendance' => $attendance->id]) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('students.attendances.destroy', ['student' => $student->id, 'attendance' => $attendance->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                    @if($attendance->absent_sessions >= 3)
                        <span class="text-danger">❌ Học lại</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
