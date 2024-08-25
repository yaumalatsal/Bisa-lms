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
                <h2>{{ $course->title }} - Questions</h2>

                <form action="{{ route('siswa.courses.submitAnswers', $course->id) }}" method="POST">
                    @csrf
                    @foreach ($questions as $index => $question)
                        <div class="mb-3">
                            <label for="question{{ $index }}" class="form-label">{{ $index + 1 }}.
                                {{ $question->question_text }}</label>
                            <textarea name="answers[{{ $question->id }}]" id="question{{ $index }}" class="form-control" rows="3"></textarea>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Submit Answers</button>
                </form>
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
