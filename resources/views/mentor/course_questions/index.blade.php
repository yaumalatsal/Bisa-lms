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

            <div class="container">
                <h2>{{ $course->title }} - Questions</h2>
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createQuestionModal">Add
                    Question</button>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->question_text }}</td>
                                <td>
                                    <button class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editQuestionModal-{{ $question->id }}">Edit</button>

                                    <a href="#" class="btn btn-danger"
                                        onclick="confirmDeleteQuestion({{ $question->id }})">
                                        Delete
                                    </a>
                                    <form id="delete-form-{{ $question->id }}" action="{{ route('course.questions.destroy', [$course->id, $question->id]) }}"
                                        method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Create Question Modal -->
            <div class="modal fade" id="createQuestionModal" tabindex="-1" aria-labelledby="createQuestionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('course.questions.store', $course->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createQuestionModalLabel">Add Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="question_text">Question Text</label>
                                    <textarea name="question_text" class="form-control" required>{{ old('question_text') }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Question Modals -->
            @foreach ($questions as $question)
                <div class="modal fade" id="editQuestionModal-{{ $question->id }}" tabindex="-1"
                    aria-labelledby="editQuestionModalLabel-{{ $question->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('course.questions.update', [$course->id, $question->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editQuestionModalLabel-{{ $question->id }}">Edit Question
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="question_text">Question Text</label>
                                        <textarea name="question_text" class="form-control" required>{{ $question->question_text }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
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
