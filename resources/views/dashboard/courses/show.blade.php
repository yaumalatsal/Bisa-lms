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
            {{-- <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{ route('courses.create') }}" class="btn btn-primary">Add New Course</a>
                </div>
            </div> --}}

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="container mt-5">
                <h1>{{ $course->title }}</h1>
                <p>{{ $course->description }}</p>
            
                <div class="accordion" id="courseMaterialsAccordion">
                    @foreach($materials as $index => $material)
                    <div class="card">
                        <div class="card-header" id="heading{{ $index }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                                    {{ $index + 1 }}. {{ $material->title }}
                                </button>
                            </h2>
                        </div>
            
                        <div id="collapse{{ $index }}" class="collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-parent="#courseMaterialsAccordion">
                            <div class="card-body">
                                {!! $material->content !!}
                                @if($material->is_read)
                                <span class="badge badge-success">Read</span>
                                @else
                                <form action="{{ route('siswa.materials.markRead', $material->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">Mark as Read</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            
                <div class="mt-5">
                    <h3>Questions</h3>
                    @if($allMaterialsRead)
                    <form action="{{ route('siswa.questions.answer', $course->id) }}" method="POST">
                        @csrf
                        @foreach($questions as $question)
                        <div class="form-group">
                            <label for="question_{{ $question->id }}">{{ $question->question_text }}</label>
                            <textarea name="answers[{{ $question->id }}]" id="question_{{ $question->id }}" class="form-control" rows="3" required></textarea>
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Submit Answers</button>
                    </form>
                    @else
                    <p class="text-warning">You must read all the materials before answering the questions.</p>
                    @endif
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
