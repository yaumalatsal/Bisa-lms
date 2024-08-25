@section('title-page')
    Daftar Jawaban
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

            <table id="answersTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Student</th>
                        <th>Score</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($answers as $answer)
                        <tr>
                            <td>{{ $answer->courseQuestion->question_text }}</td>
                            <td>{{ $answer->answer_text }}</td>
                            <td>{{ $answer->siswa->nama }}</td>
                            <td>{{ $answer->score ?? 'Not Graded' }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#scoreModal" data-answer-id="{{ $answer->id }}"
                                    data-score="{{ $answer->score }}">
                                    Update Score
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>

                <!-- Modal for Updating Score -->
                <div class="modal fade" id="scoreModal" tabindex="-1" aria-labelledby="scoreModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" method="POST" id="updateScoreForm">
                                @csrf
                                <input type="hidden" id="courseId" value="{{ $courseId }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scoreModalLabel">Update Score</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="score" class="form-label">Score</label>
                                        <input type="number" class="form-control" name="score" id="score"
                                            min="0" max="100" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Score</button>
                                </div>
                            </form>
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

        $(document).ready(function() {
            $('#answersTable').DataTable();
        });


        $('#scoreModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var answerId = button.data('answer-id');
        var score = button.data('score');
        var modal = $(this);
        var form = modal.find('form');
        var courseId = $('#courseId').val();
        
        form.attr('action', '/courses/' + courseId + '/answers/' + answerId + '/update-score');
        modal.find('#score').val(score);
    });
    </script>
@endsection
