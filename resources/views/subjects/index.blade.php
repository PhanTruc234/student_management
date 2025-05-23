@extends('master')

@section('title')
    Danh sách môn học
@endsection

@section('content')
    <form action="{{ route('subjects.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm môn học" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>

    <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">Thêm môn học mới</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-2">
        <thead>
            <tr>
                <th>Mã Môn Học</th>
                <th>Tên Môn Học</th>
                <th>Số tín</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td class="align-middle">{{ $subject->code }}</td>
                    <td class="align-middle">{{ $subject->name }}</td>
                    <td class="align-middle">{{ $subject->credit }}</td>
                    <td class="align-middle">
                        <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $subjects->appends(['search' => request('search')])->links() }}
    </div>
    <div>
        <a href="{{ route('students.index', $student->id) }}" class="btn btn-primary">Quay lại</a>
    </div>
@endsection
