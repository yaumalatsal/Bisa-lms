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
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Add New Course</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Courses</div>
                <div class="card-body">
                    <table id="table-one" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->title }}</td>
                                    <td>{{ Str::limit($course->description, 50) }}</td>
                                    <td>{{ $course->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td><img src="{{ asset('storage/' . $course->image) }}" alt="course image"
                                            width="50"></td>
                                    <td>
                                        <div class="view mb-3">
                                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary btn-sm">Show Materi</a>
                                            <a href="{{ route('course.questions.index', $course->id) }}" class="btn btn-primary btn-sm">Show Question</a>
                                            
                                        </div>
                                        <a href="{{ route('courses.edit', $course->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="confirmDeleteCourse({{ $course->id }})">
                                            Delete
                                        </a>
                                        <form id="delete-form-{{ $course->id }}" action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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


        function confirmDeleteCourse(id) {
            Swal.fire({
                title: 'Apa Yakin Menghapus Materi?',
                text: "Anda Tidak bisa mengulangi lagi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
