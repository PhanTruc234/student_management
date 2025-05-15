@extends('master')

@section('title')
    Quản lý điểm của sinh viên: {{ $student->name }}
@endsection

@section('content')
    <h3>Danh sách điểm của sinh viên: {{ $student->name }}</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('students.scores.index', $student->id) }}" method="GET" class="mb-3">
        <button type="submit" name="filter" value="fail" class="btn btn-warning">Lọc môn học cần học lại</button>
        <a href="{{ route('students.scores.index', $student->id) }}" class="btn btn-secondary">Xóa lọc</a>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Môn học</th>
                <th>Điểm</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scores as $score)
                <tr>
                    <td class="align-middle">{{ $score->subject->name }}</td>
                    <td class="align-middle">{{ $score->score }}</td>
                    <td class="align-middle">
                        <a href="{{ route('students.scores.edit', [$student->id, $score->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                        @if($score->score < 4)
                            <span class="text-danger">❌ Học lại</span>
                        @else
                            <span class="text-success">✅ Đạt</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('students.scores.create', $student->id) }}" class="btn btn-primary">Thêm điểm mới</a>
    <a href="{{ route('students.index', $student->id) }}" class="btn btn-primary">Quay lại</a>
    <div class="mb-3 mt-3">
        <a href="{{ route('students.scores.index', ['student' => $student->id, 'sort' => 'score_desc']) }}" class="btn btn-info">Sắp xếp điểm giảm dần</a>
        <a href="{{ route('students.scores.index', ['student' => $student->id, 'sort' => 'score_asc']) }}" class="btn btn-info">Sắp xếp điểm tăng dần</a>
    </div>
@endsection
