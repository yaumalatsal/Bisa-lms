@section('title-page')
    
@endsection

@section('css')
    <style>
        .card-step {
            min-height: 350px;
        }

        .card-step .deskripsi-step {
            height: 90px;
        }

        .ranking-card {
            background-color: #f8f9fa;
            border-left: 5px solid #007bff;
        }

        .ranking-number {
            width: 60px;
            height: 60px;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .student-info h4 {
            color: #343a40;
        }

        .student-info p {
            color: #6c757d;
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

            <div class="container ">
                <h1 class="mb-4 text-center">Point Rankings</h1>
                <div class="row justify-content-center">
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($rankings as $ranking)
                        <div class="col-md-8 mb-4">
                            <div class="ranking-card p-3 rounded shadow-sm d-flex align-items-center">
                                <div class="ranking-number rounded-circle d-flex align-items-center justify-content-center">
                                    <h2 class="mb-0">{{ $index }}</h2>
                                    @php
                                        $index++
                                    @endphp
                                </div>
                                <div class="student-info ms-4">
                                    <h4 class="mb-1">{{ $ranking->nama }}</h4>
                                    <p class="mb-0">Course Score: <strong>{{ $ranking->total_course_score ?? 0 }}</strong></p>
                                    <p class="mb-0">Answer Score: <strong>{{ $ranking->total_answer_score ?? 0 }}</strong></p>
                                    <p class="mb-0">Product Score: <strong>{{ $ranking->total_penilaian ?? 0}}</strong></p>
                                    <p class="mb-0">Total Score: <strong>{{ $ranking->total_score }}</strong></p>
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
