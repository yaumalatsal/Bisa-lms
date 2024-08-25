@section('title-page')
    Dashboard Siswa
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


            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row ">
                <div class=" rounded">
                    <h4 class="pt-2">Course {{ $course->title }}</h4>
                    <p>{{ $course->description }}</p>
                </div>
                <div class="col-md-10">
                    <div class="d-flex row bg-light my-3 justify-content-center px-2">
                        <div class="col-md-8 my-4 ">
                            <h3>{{ $material->title }}</h3>
                            <hr>
                            {!! $material->content !!}

                            <div class="d-flex justify-content-between mt-5">
                                @if ($previousMaterial)
                                    <a href="{{ route('siswa.courses.showMaterial', $previousMaterial->id) }}"
                                        class="btn btn-primary">Previous</a>
                                @else
                                    <span class="btn btn-secondary disabled">Previous</span>
                                @endif

                                @if ($nextMaterial)
                                    <a href="{{ route('siswa.courses.showMaterial', $nextMaterial->id) }}"
                                        class="btn btn-primary">Next</a>
                                @elseif ($completion)
                                    @if ($completion->completed == 1)
                                    <span class="btn btn-secondary disabled">Next</span>
                                    @endif
                                @else
                                    <a href="{{ route('siswa.courses.showQuestions', $course->id) }}"
                                        class="btn btn-primary">Go to Questions</a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="my-3">
                        <h3>Materi Course</h3>
                        <ul class="list-group">
                            @foreach ($materials as $index => $material)
                                <li class="list-group-item">
                                    <a href="{{ route('siswa.courses.showMaterial', $material->id) }}">
                                        @if ($material->is_read)
                                            <i class="mdi mdi-check-circle"></i>
                                        @endif
                                        {{ $material->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item">
                                @if ($completion)
                                    @if ($completion->completed == 1)
                                    <span class="text-link">Soal Pertanyaan</span>
                                    @endif
                                @elseif ($allMaterialsRead)
                                <a href="{{ route('siswa.courses.showQuestions', $course->id) }}"> Soal Pertanyaan </a> 
                                @else 
                                <span class="text-link">Soal Pertanyaan</span>
                                @endif
                            </li>
                        </ul>
                    </div>
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
