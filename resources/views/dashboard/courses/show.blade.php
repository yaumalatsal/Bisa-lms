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

            <div class="container">
                <div class="row bg-light my-3 rounded">
                    <h1 class="py-2">Course {{ $course->title }}</h1>
                    <p>{{ $course->description }}</p>
                </div>

                <div class="my-4">
                    <h3>Materi Course</h3>
                    @foreach ($materials as $index => $material)
                        <div class="card">
                            <div class="card-header" id="heading{{ $index }}">
                                <h4 class="mb-0">
                                    <a href="#" class="text-dark">{{ $material->title }}</a>
                                </h4>
                            </div>

                            <div id="card" class="card">
                                <div class="card-body pb-0">
                                    @if ($material->is_read)
                                        <p><small>Dibaca Pada {{ $material->read_at }}</small></p>
                                    @endif
                                    <a href="{{ route('siswa.courses.showMaterial', $material->id) }}"
                                        class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                @if ($allMaterialsRead)
                    <h3 class="mt-4">Course Questions {{ $allMaterialsRead }}</h3>
                    @foreach ($answers as $index => $answer)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="mb-0">
                                <label for="question{{ $index }}" class="form-label">{{ $index + 1 }}.
                                    {{ $answer->courseQuestion->question_text }}</label>
                            </h4>
                            <span>Score: {{ $answer->score ?? '' }}</span>
                        </div>

                        <div id="card" class="card">
                            <div class="card-body pb-0">
                                <textarea id="question{{ $index }}" class="form-control"  readonly>{{ $answer->answer_text ?? 'Belum Dijawab' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
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
