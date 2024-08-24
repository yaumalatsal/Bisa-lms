@section('title-page')
    Dashboard Mentor
@endsection

@section('css')
    <style>
        .card-step {
            min-height: 350px;
        }

        .card-step .deskripsi-step {
            height: 90px;
        }
    </style>
@endsection

@extends('mentor/template/index')
@section('content')
    <div class="container-fluid">
        <div class="row">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Edit Course</div>

                <div class="card-body">
                    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ $course->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="1" {{ $course->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $course->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Course Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="course image" width="100" class="mt-2">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Course</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $("#table-one").DataTable();
        });
    </script>
@endsection
