@section('title-page')
    Penilaian Mentor
@endsection

@section('css')
<style>
    /* Gaya untuk modal */
    .modal-dialog{
        max-width: 75%;
    }

    /* Gaya untuk kartu langkah */
    .card-step {
        min-height: 350px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card-step:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .card-step .deskripsi-step {
        height: 90px;
    }

    /* Gaya untuk tabel */
    .table thead {
        background-color: #f8f9fa;
    }

    .table th {
        font-weight: bold;
        text-transform: uppercase;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Gaya animasi untuk judul */
    h3 {
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        color: #333;
        margin-bottom: 30px;
        animation: fadeInDown 1s ease-in-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-step">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="col-md-12">
                            <h3>Riwayat Penilaian</h3> 
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-one">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Langkah</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($nilai as $datanilai)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$datanilai->nama_step}}</td>
                                            <td>
                                                <a href="{{$datanilai->file_nilai}}" target="_blank">
                                                    {{$datanilai->file_nilai}}
                                                </a>
                                            </td>
                                            <td>{{ $datanilai->keterangan }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    </div>               
                </div>
            </div>            
        </div>    
    </div>
    <br>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $("#table-one").DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false
        });

        $(".editNilai").click(function(){
            var id_step = $(this).data('idstep');
            var langkah = $(this).data('langkah');
            var namafile = $(this).data('file');
            var id_penilaian = $(this).data('idpenilaian')

            $("#ed-nama-step").val(langkah);
            $("#ed-id-step").val(id_step);
            $("#ed-nilai").val(namafile);
            $("#ed-id-penilaian").val(id_penilaian);
        });
    });
</script>
@endsection
