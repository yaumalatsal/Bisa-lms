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

        

        
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card-body">
            <div class="row p-4">
                <div class="col-md-5">
                    <center><img src="{{asset('assets/images/ilustration/step/mentor.gif')}}" style="width:80%" alt=""></center>
                </div>
                <div class="col-md-6">
                    <br>
                    <h2>Selamat Datang, Siswa</h2>
                    <p>BISa adalah platform monitoring dan inkubasi online yang membantu para siswa untuk merumuskan
                        produk dan konsep bisnis nya. Disini peran mentor adalah untuk membimbing ide ide cemerlang dari siswa sesuai dengan syarat
                        standar produk yang layak jual dan layak di publish. Mohon dukungannya :)
                        <br>
                        <!-- <a href="{{url('/submitDeck')}}" class="btn btn-primary">Submit Progress <i class="fas fa-arrow-alt-circle-right"></i></a> -->
                    </p>                         
                    <p>
                        <table class="table">
                            <tr>
                                <td>Nama Lengkap </td>
                                <td> : </td>
                                <td>{{$siswa->nama}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir </td>
                                <td> : </td>
                                <td>{{$siswa->tanggal_lahir}}</td>
                            </tr>
                            <tr>
                                <td>Nomor Induk </td>
                                <td> : </td>
                                <td>{{$siswa->nomor_induk}}</td>
                            </tr>
                            <tr>
                                <td>Score </td>
                                <td> : </td>
                                <td>{{$totalScore}}</td>
                            </tr>
                            <tr>
                                <td>Level </td>
                                <td> : </td>
                                <td>{{$level}}</td>
                            </tr>
                        </table>
                    </p>
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
