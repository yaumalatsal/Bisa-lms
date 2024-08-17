@section('title-page')
    Product BUMDES
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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-6">
                            Daftar Produk Saya 
                        </div>
                        <div class="col-md-4 col-6">
                            <button class="btn  btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalTambahProduk"> <span class="fa fa-plus"></span> Tambah Produk</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th width="20">No</th>
                            <th>Nama Produk</th>
                            <th>Tanggal Upload</th>
                            <th width="20">Action</th>
                        </tr>
                        @php $no = 1@endphp
                        @foreach($produk as $data)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$data->nama_produk}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- <a class="btn btn-primary" data-bs-toggle="modal" ><span class="fa fa-eye"></span></a> -->
                                        <a class="btn btn-warning produk-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"                                            
                                            data-bs-toggle="modal"
                                            data-id = "{{$data->id}}"
                                            data-nama="{{$data->nama_produk}}"
                                            data-foto="{{$data->foto_produk}}"
                                            data-harga="{{$data->harga}}"
                                            data-kategori="{{$data->nama_kategori}}"
                                            data-deskripsi="{{$data->deskripsi_produk}}"
                                        >
                                            <span class="fa fa-edit"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalTambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
          <form action="{{url('/tambahProduk')}}" method="post" enctype="multipart/form-data">
              {{csrf_field()}}
          <div class="row">
              
              <div class="col-md-6 col-12">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input required="required" type="text"  name="nama_produk" class="form-control" id="nama_produk" placeholder="">
                    <br>
                    <label for="harga_produk" class="form-label">Harga</label>
                    <input required="required" type="number"  name="harga" class="form-control" id="harga_produk" placeholder="">
                    <br>
                    <label for="kategori_produk" class="form-label">Katgori</label>
                    <select required="required" class="form-control"  name="kategori" >
                        @foreach($kat as $data)
                        <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                    <textarea required="required" class="form-control" name="deskripsi_produk" id="" cols="30" rows="4"></textarea>
              </div>
              <div class="col-md-6">
                    <center><img src="{{asset('assets/images/noimage.png')}}" style="width:80%" alt="" id="img-prev"></center>
                    <br>
                    <label for="fotoproduk">Cover Produk</label>
                    <input type="file" required="required" name="foto_produk" id="fotoproduk" class="form-control">
                </div>
                
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">+ Tambah Data</button>
        </form>
    </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
          <form action="{{url('/editProduk')}}" method="post" enctype="multipart/form-data">
              {{csrf_field()}}
          <div class="row">
              
              <div class="col-md-6 col-12">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" required="required" name="nama_produk" class="form-control" id="ed-nama-produk" placeholder="">
                    <input type="hidden" name="id_produk" class="form-control" id="ed-id-produk" placeholder="">
                    <br>
                    <label for="harga_produk" class="form-label">Harga</label>
                    <input type="number" required="required" name="harga" class="form-control" id="ed-harga-produk" placeholder="">
                    <br>
                    <label for="kategori_produk" class="form-label">Kategori</label>
                    <select class="form-control" required="required"  name="kategori" >
                        @foreach($kat as $data)
                        <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                    <textarea class="form-control" required="required" name="deskripsi_produk" id="ed-deskripsi-produk" cols="30" rows="4">                        
                    </textarea>
              </div>
              <div class="col-md-6">
                    <center><img src="{{asset('assets/images/noimage.png')}}" id="ed-foto-produk" style="width:80%" alt=""></center>
                    <br>
                    <label for="fotoproduk">Cover Produk</label>
                    <input type="file" name="foto_produk" required="required" id="edit-fotoproduk" class="form-control">
                </div>
                
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">+ Simpan</button>
        </form>
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
