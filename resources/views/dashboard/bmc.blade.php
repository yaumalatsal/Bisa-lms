@section('title-page')
    Step 3 : Membuat Busines Model Cnvas
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:75%;
        }
        

        @media only screen and (max-width:720px){
            .modal-dialog{
                max-width:100%;
            }         
        }
    </style>
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <center><img src="{{asset('assets/images/ilustration/step/bmc.gif')}}" style="width:60%" class="m-5" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-5"> <strong>Selamat Datang di Tahap BMC </strong></h2>
                            <h3>Apa itu BMC  ?</h3>
                            <p>Business Model Canvas (BMC) adalah alat manajemen strategis untuk mendefinisikan dan mengomunikasikan ide atau konsep bisnis dengan cepat dan mudah.
                                Ini adalah dokumen satu halaman yang bekerja melalui elemen dasar bisnis atau produk, menyusun ide dengan cara yang efektif.</p>
                            <button class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalBMC"> <i class="fas fa-play"></i> &nbsp;Klik Untuk Melihat Video Penjelasan BMC  </button>
                        </div>    
                    </div>         
                </div>
            </div>
        
            <h4>Business Model Canvas di bagi menjadi 9 poin, yaitu : </h4>
            <div class="row">
                @foreach($bmc as $data)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <center>
                            <img src="{{asset('assets/images/'.$data->icon)}}" alt="" class="w-50 mt-2">
                            <h4 class="mt-3" >{{$data->judul}}</h4>
                            <br>
                            <a href="{{url('detail_bmc/'.$data->id)}}" class="btn btn-primary w-100">Lengkapi Data <i class="fas fa-arrow-right"></i> </a>
                            </center>
                        </div>
                    </div>
                </div>
                @endforeach                
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h5>Jika semua borang Business Model Canvas telah selesai diisi, silahkan klik timbol <strong>Submit BMC</strong>
                            untuk segera di review oleh mentor </h5>
                        </div>
                        <div class="col-md-2">
                            <a href="submit_bmc" class="btn btn-md btn-danger text-white"> Submit BMC <i class=" fas fa-arrow-circle-right"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- materi modal -->
<div class="modal fade" id="modalBMC" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
        <iframe width="100%" height="500" src="https://www.youtube.com/embed/didsTfkv_0g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="modal-footer">
            <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
        // $("#jadwalTabel").DataTable({
        //   "responsive": true,
        //     "autoWidth": false,
        // });

        $("#fotoproduk").change(function(){
            readURL(this,'#img-prev');
        });        
        $("#edit-fotoproduk").change(function(){
            readURL(this,'#ed-foto-produk');
        });
        
        $(".produk-edit").click(function(){
            var id   = $(this).data('id');
            var nama = $(this).data('nama');
            var namafile = $(this).data('foto');
            var foto = '{{asset('cover_produk/')}}/'+namafile;
            var harga = $(this).data('harga');
            var kategori = $(this).data('kategori');
            var deskripsi = $(this).data('deskripsi');
            $('#ed-nama-produk').val(nama);
            $('#ed-harga-produk').val(harga);
            $('#ed-deskripsi-produk').val(deskripsi);
            $('#ed-id-produk').val(id);            
            $('#ed-foto-produk').attr('src',foto);
        });
    });
</script>
@endsection
