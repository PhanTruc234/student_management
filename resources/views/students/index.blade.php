@extends('master')
@section('title')
    Danh sách sinh viên
@endsection

@section('content')
    <!-- Form tìm kiếm -->
    <form action="{{ route('students.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm sinh viên
            " value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            @if (request('search'))
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Xóa tìm kiếm</a>
            @endif
        </div>
    </form>

    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Thêm sinh viên mới</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($students->isEmpty())
        <div class="alert alert-info">
            Không tìm thấy sinh viên nào.
        </div>
    @else
        <table class="table mt-2 mb-2">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>MSV</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>DTB</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $student->code }}</td>
                        <td class="align-middle">{{ $student->name }}</td>
                        <td class="align-middle">{{ $student->email }}</td>
                        <td class="align-middle">{{ ucfirst($student->gender) }}</td>
                        <td class="align-middle">{{ $student->dob }}</td>
                        <td class="align-middle">
                            @if($student->scores->count() > 0)
                                {{ number_format($student->scores->avg('score'), 2) }}
                            @else
                                Chưa có điểm
                            @endif
                        </td>
                        <td style="width: 180px;" class="align-middle">
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary btn-sm mt-2">Sửa</a>
                            <a href="{{ route('students.scores.index', ['student' => $student->id]) }}" class="btn btn-primary btn-sm mt-2">điểm</a>
                            <a href="{{ route('students.attendances.index', $student->id) }}" class="btn btn-primary btn-sm mt-2">điểm danh</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mt-2">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $students->appends(['search' => request('search')])->links() }}
        </div>
        <div>
            <a href="{{ route('students.index', ['sort' => 'average_score_desc', 'search' => request('search')]) }}" class="btn btn-success mb-3">
                Sắp xếp theo điểm trung bình giảm dần
            </a>
        </div>
        {{-- <div>
            <a href="{{ route('subjects.index', ['student_id' => $student->id]) }}" class="btn btn-primary btn-sm mt-2">Quản lý môn</a>
        </div> --}}
    @endif
@endsection