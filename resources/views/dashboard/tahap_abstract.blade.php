@section('title-page')
    Abstrak Produk
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:75%;
        }

        .table-result{
            background-color:#ffff;
            font-size:14px
        }

        .member-area{
            padding:10px;
            background-color:#ededed; 
        }

        h4 small{
            font-size:12px;
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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-2">
                        <h3>Buat Produk Hebatmu !</h3>                
                        <small>
                            Dalam pembangunan StartUp, produk akan menjadi senjata fundamental agar dapat bersaing dan berkembang.
                            Buatlah produk terbaikmu, yang kreatif , inovatif, dan berimpact besar. 
                        <small>
                        <br><br>
                        @if (session('status'))
                            <div  style="width:100%" class="alert alert-primary" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="register_produk" method="post">
                            {{csrf_field()}}
                            <h4> <span class="fas fa-archive"></span>&nbsp; Nama Produk <br>
                            <small>Nama produk bisa berasal dari singkatan atau istilah yang berhubungan dengan produkmu</small>
                            </h4>
                            <input type="text" name="nama_produk" class="form-control">
                      
                            <br>
                            <h4><span class="fas fa-align-left"></span>&nbsp;Deskripsi Singkat Produk <br>
                            <small>Deskripsikan produkmu secara singkat. Deskripsi dapat mencakup 
                            bidang yang dinanungi, sasaran pasar, bentuk produk, alur singkat penggunaan produk,
                            dan hal lain yang berhubungan dengan penggambaran awal produkumu.
                            </small>
                            </h4>
                            <textarea name="deskripsi"  class="form-control" rows="10"></textarea>
                            <br>
                            <h4><span class="fas fa-user"></span>&nbsp; Mentor <br>
                            <small>Mentor yang dipilih adalah wirausaha sukses yang telah memiliki pengalaman dan wawasan yang luas mengenai kewirausahaan </small>
                            </h4>
                            <select name="mentor" id="" class="form-control">
                                @foreach($getmentor as $data)
                                <option value="{{$data->id}}">{{$data->nama}}</option>
                                @endforeach
                            </select>
                            <br>
                            <button class="btn btn-primary float-end" type="submit">Selanjutnya <span class="fas fa-chevron-right"></span></button>
                        </form>
                    </div>             
                </div>
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
