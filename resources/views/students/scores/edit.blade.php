@extends('master')

@section('title')
    Chỉnh sửa điểm cho sinh viên: {{ $student->name }}
@endsection

@section('content')
    <h3>Chỉnh sửa điểm cho sinh viên: {{ $student->name }}</h3>

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

    <form action="{{ route('students.scores.update', [$student->id, $score->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="score" class="form-label">Điểm</label>
            <input type="number" step="0.01" class="form-control" id="score" name="score" value="{{ $score->score }}" min="0" max="10" required>
            @error('score')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật điểm</button>
        <a href="{{ route('students.scores.index', $student->id) }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection