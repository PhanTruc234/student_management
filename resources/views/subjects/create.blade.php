@extends('master')

@section('title')
    Thêm môn học
@endsection

@section('content')
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Môn Học</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="credit" class="form-label">Số tín chỉ</label>
            <input type="number" class="form-control" name="credit" id="credit" value="{{ old('credit', $subject->credit ?? '') }}" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Thêm môn học</button>
    </form>
@endsection
