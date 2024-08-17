
@extends('template/dashboard_index')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"></link>
    <link rel="stylesheet" href="{{asset('assets/datatables-responsive/css/responsive.bootstrap4.min.css')}}"></link>
    <style>
        body{
            background-color:#E5E5E5;
        }
        #cover-page{            
            margin:0px;
            width:100%;
            overflow-x:hidden;
            min-height: 50vh;
            padding-top: 18vh;
            background-image: linear-gradient(to right, #03192E , #153A5C);            
        }

        #cover-page h1{
            color:white;
            font-size:26px;
            font-weight:700;
        }
        #cover-page .iso{
            width:100%;
            margin-top:3%;
        }
        #cover-page .desc{
            padding:2% 10%;
        }
        #cover-page .desc .btn{
            padding:10px 25px;
        } 

        #alur{
            position: relative;
            min-height:80vh;   
            width:100%;      
            margin-top:-8vh; 
            margin-bottom:10vh;                                    
        }
        #alur .col-md-3{
            padding:10px;
        }
        #alur .card-alur-wrapper{
            margin-top:-4%;                      
        }
        #alur .card-alur{
            background-color:#ffff;
            min-height:250px;
            text-align:center;
            cursor:pointer;                                 
        }
        #alur .card-alur img{
            width:40%;
            margin-top: 30%;
        }
        #alur .card-alur p{
            margin-top:10px;
            font-weight:700;
        }

        #alur .profil-bumdes{
            background-color:#fff;
            padding:0.1px;
            margin:0px;
            margin-top:15px;
        }
        #alur .profil-bumdes .profil-wrapper{
            margin:4%;
            width:100%;
        }
        #alur .profil-bumdes .profil-wrapper h2{
            width:100%;
            font-weight:700;
            font-size:20px;
            font-family:nunito;
        }

        #alur .profil-bumdes table .label{
            width:40%;
        }
        #alur .profil-bumdes table td{
            padding-bottom:20px;
        }
        #alur .profil-bumdes table .colon{
            width:5%;
        }
        #alur .profil-bumdes .map-area{
            width:100%;
            min-height:250px;
            background-color:#ededed;
        }

        #tambahPotensiModal .modal-dialog{
          max-width:60%;
        }

        

        @media only screen and (max-width: 720px) {  
            #cover-page{
                min-height:70%;
            } 
            #cover-page .iso{
                display:none;
            }
            #cover-page .desc{
                text-align:center;
            }
            #cover-page .desc h1{
                font-size:40px;
            }

        }
    </style>
@endsection
@section('content')
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-6 col-12 desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito"><span class="color-main">Sharing dan Mentoring</span><br> BUMDES {{session('nama_bumdes')}}<span></h1>
                <p class="text-white nunito"></p>                
            </div>
        </div>   
</section>

<section id="alur">
    <div class="container">
        <div class="row card-alur-wrapper">
            <div class="col-md-3" onclick="window.location.href='{{url('/dashboard')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur1.png')}}" alt="">
                    <p class="nunito">Profil Bumdes</p>
                </div>
            </div>
            <div class="col-md-3" onclick="window.location.href='{{url('/sharing')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur2.png')}}" alt="">
                    <p class="nunito">Sharing dan Mentoring</p>
                </div>
            </div>
            <div class="col-md-3" onclick="window.location.href='{{url('/dashboard_ujicoba')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur3.png')}}" alt="">
                    <p class="nunito">Uji Coba Produk</p>
                </div>
            </div>
            <div class="col-md-3" onclick="window.location.href='{{url('/dashboard_launching')}}'">
                <div class="card-alur">
                    <img src="{{asset('assets/images/alur4.png')}}" alt="">
                    <p class="nunito">Launching Produk</p>                
                </div>
            </div>                        
        </div>
        <div class="row profil-bumdes">
            <div class="row profil-wrapper"> 
                <div class="col-md-12 col-lg-12 col-sm-12">
                @if(isset($upload_berhasil))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Upload Produk Berhasil</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(isset($upload_gagal))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Gagal Upload Produk</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                </div>               
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <button data-toggle="modal" data-target="#tambahPotensiModal" class="btn btn-warning float-right">Tambah Potensi Desa &nbsp;<span class="fa fa-plus"></span></button>
                    <h2 class="mb-0">Pengolahan Potensi Desa</h2>
                    <small>Branding dan Bagikan Potensi Desa </small>
                    <br><br>                              
                </div>
                <div class="row col-md-12 col-lg-12 col-sm-12 col-12">
                    @foreach($produk as $datas)
                    <div class="col-md-3 col-lg-3 col-6 product-wrapper" data-aos="fade-up" data-aos-duration="1500" onclick="window.location.href='{{url('/dashboard_detail_produk/'.$datas->produk_id)}}'">
                        <div class="card-produk">
                            <div class="cover-produk" style="background:url('{{asset('cover_produk/'.$datas->foto_produk)}}');background-size:cover;"></div>
                            <div class="desc-produk">
                                <h5>{{$datas->nama_produk}}</h5>
                                <p>{{$datas->nama_bumdes}}</p>
                            </div>
                        </div>                    
                    </div>   
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row profil-bumdes">
            <div class="row profil-wrapper">
                <h2 class="mb-0">Pelatihan Yang Diikuti</h2>
                    <small>Dibawah ini adalah beberapa pelatihan yang sudah anda enroll</small>
                    <br><br>               
                <div class="row col-md-12 col-lg-12 col-sm-12 col-12">
                    @foreach($enroll as $data)
                        <div class="col-lg-6 col-md-6 col-12">                       
                        <div class="card-pelatihan">
                            <div class="cover-card">
                                <img src="{{asset('cover_pelatihan/'.$data->foto_cover)}}" alt="">
                            </div>
                            <div class="caption-card">                      
                                <a class="enroll" href="{{url('/dashboard_detail_pelatihan_user/'.$data->id)}}">
                                <span class="fa fa-sign-in-alt"></span>
                                </a>
                                <p>{{$data->nama_pelatihan}}
                                <br>
                                <p class="mentor"><span class="fa fa-user"></span> &nbsp;{{$data->mentor}}</p>
                                </p>
                                
                            </div>
                            </div>                     
                        </div>
                    @endforeach  
                </div>
                        
            </div>
        </div>
    </div>  
</section>


<!-- modal tambahPotensiModal -->
<div class="modal fade" id="tambahPotensiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tabah Produk Potensi Desa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{url('/tambahPotensi')}}" method="post" enctype="multipart/form-data">
      <div class="modal-body">
            {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" required="required" name="nama_produk" class="form-control">
              </div>
              <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea name="deskripsi_produk" id="" required="required" class="form-control" rows="6"></textarea>
              </div>
              <div class="form-group">
                <label>Harga Produk</label>
                <input type="number" name="harga" class="form-control" required="required">                
              </div>
            </div>
            <div class="col-lg-6">
                <center>
                    <img src="{{asset('assets/images/noimage.png')}}" alt="" style="height:200px" id="img-prev">
                </center>
                <div class="form-group">                
                    <label for="foto-produk" class="btn btn-warning"><span class="fa fa-camera"></span>&nbsp; Pilih Cover Produk... </label>
                    <input type="file" class="d-none" id="foto-produk" name="foto_produk" required="required">
                </div>
                <div class="form-group">
                    <label>Kategori Produk</label>
                    <select name="kategori" class="form-control" required="required">
                    <option value="1">Perkebunan</option>
                    <option value="2">Kelautan</option>
                    <option value="4">Persawahan</option>
                    <option value="5">Lainnya</option>
                    </select>                
                </div>          
            </div>
          </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah Potensi <span class="fa fa-upload"></span></button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end of tambahPotensiModal -->
@endsection
@section('js')
<script src="{{asset('assets/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script>
    $(function(){
        $("#jadwalTabel").DataTable({
          "responsive": true,
            "autoWidth": false,
        });

        
        $("#foto-produk").change(function(){
            readURL(this,'#img-prev');
        });
    });
</script>
@endsection