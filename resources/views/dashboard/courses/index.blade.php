@extends('dashboard_template/index')

{{-- @section('title-page')
    Dashboard Mentor
@endsection --}}

@section('css')
    <style>
        .container-fluid {
            background: linear-gradient(to right, #f0f2f5, #ffffff);
            padding: 2rem;
        }

        .card-step {
            min-height: 350px;
        }

        .card-step .deskripsi-step {
            height: 90px;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 14rem;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .card-img-top:hover {
            opacity: 0.8;
        }

        .card-body {
            background-color: #ffffff;
            padding: 1.5rem;
            border-top: 3px solid #007bff;
            position: relative;
            overflow: hidden;
        }

        .card-body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #00d084);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.4s ease;
        }

        .card-body:hover::before {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .card-title {
            margin-bottom: 1rem;
            font-size: 1.25rem;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .completed-tag {
            background-color: #00d084;
            color: #fff;
            border-radius: 12px;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .animate__animated {
            animation-duration: 1s;
        }

        .animate__fadeIn {
            animation-name: fadeIn;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="mb-4 text-center font-weight-bold text-primary">Available Courses</h1>
            </div>
        </div>
        
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4 animate__animated animate__fadeIn">
                    <div class="card shadow bg-body-tertiary rounded">
                        <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}">
                        <div class="card-body">
                            <div class="card-title">
                                <h5 class="my-auto">{{ $course->title }}</h5>
                                @if ($course->courseCompletions->isNotEmpty() && $course->courseCompletions[0]->completed == 1)
                                    <span class="completed-tag"><i class="mdi mdi-check-circle"></i> Completed</span>
                                @endif
                            </div>
                            <p class="card-text">{{ $course->description }}</p>
                            <a href="{{ route('siswa.courses.show', $course->id) }}" class="btn btn-primary">View Course</a>
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
