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

@extends('dashboard_template/index')
@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Add New Course</a>
                </div>
            </div> --}}

            <div class="container mt-5">
                <h1 class="mb-4">Available Courses</h1>
                <div class="row">
                    @foreach ($courses as $course)
                        <div class="col-md-4 mb-4">
                            <div class="card rounded" style="width: 18rem;">
                                <img src="{{ asset('storage/' . $course->image) }}" style="height: 14rem; object-fit: cover"
                                    class="object-fit-cover card-img-top" alt="{{ $course->title }}">
                                <div class="card-body">
                                    <div class="card-title d-flex justify-content-between align-items-center ">
                                        <h5 class="my-auto">{{ $course->title }}</h5>
                                        @if ($course->courseCompletions->isNotEmpty() && $course->courseCompletions[0]->completed == 1)
                                            <span class="text-sm">  <i class="mdi mdi-check-circle"></i> Completed</span>
                                        @endif

                                    </div>
                                    <p class="card-text">{{ $course->description }}</p>
                                    <a href="{{ route('siswa.courses.show', $course->id) }}" class="btn btn-primary">View
                                        Course</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
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


        function confirmDeleteQuestion(id) {
            Swal.fire({
                title: 'Apa Yakin Menghapus Pertanyaan?',
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
