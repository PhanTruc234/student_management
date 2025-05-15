@extends('master')

@section('title')
    Thêm điểm cho sinh viên: {{ $student->name }}
@endsection

@section('content')
    <h3>Thêm điểm cho sinh viên: {{ $student->name }}</h3>

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

    @if($subjects->isEmpty())
        <div class="alert alert-warning">
            Sinh viên đã có điểm cho tất cả môn học. Không thể thêm điểm mới.
        </div>
        <a href="{{ route('students.scores.index', $student->id) }}" class="btn btn-secondary">Quay lại</a>
    @else
        <form action="{{ route('students.scores.store', $student->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="subject_id">Môn học</label>
                <!-- Dropdown để chọn môn học -->
                <select name="subject_id" class="form-control" required>
                    <option value="" disabled selected>Chọn môn học</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="score">Điểm</label>
                <!-- Input để nhập điểm -->
                <input type="number" name="score" id="score" class="form-control" min="0" max="10" step="0.01" value="{{ old('score') }}" required>
                @error('score')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Thêm điểm</button>
            <a href="{{ route('students.scores.index', $student->id) }}" class="btn btn-secondary mt-3">Quay lại</a>
        </form>
    @endif
@endsection
