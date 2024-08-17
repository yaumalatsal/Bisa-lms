
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
            min-height:80vh;   
            width:100%;      
            margin-top:-12vh; 
            margin-bottom:10vh;                                    
        }        
        #alur .card-alur-wrapper{
            margin-top:-4%;
            min-height:100px;  
            margin-bottom:10px;                    
        }
        #alur .card-alur{            
            min-height:250px;
            background-color:#ffff;            
            cursor:pointer; 
            margin:0px;                                         
        }
        #alur  .desc{
           padding:30px 40px;
        }
        #alur .desc p{            
            font-family:nunito; 
            font-size:15px;
            margin-bottom:0px;          
        }

        #alur  .photo-produk img{
          margin-top:50px;
        }
        #alur  .photo-produk{
          padding:20px;        
        }
        #alur  .photo-produk p{
          font-size:15px;
          font-family:nunito;
          margin-top:10px;  
          margin-bottom:0px;
        }
        #alur  .photo-produk .kelengkapan-produk{
          padding-right:10px;
          padding-left:10px;          
        }
        #alur  .photo-produk .kelengkapan-produk .col-lg-4{
          padding:0px;
          text-align:center;
        }
        #alur  .photo-produk .kelengkapan-produk .btn{
          width:97%;          
          color:#ffff;
          font-size:10px;
          margin:3px;
        }


        #alur .profil-bumdes{            
            padding:0.1px;            
            margin:0px;
            margin-top:15px;
        }
        #alur .profil-bumdes .profil-wrapper{ 
          background-color:#ffff;
          margin:0;
          padding:2%;                     
        }
        #alur .profil-bumdes .profil-wrapper .profil-pelatihan{
          background-color:#ffff;
          padding:0px;
          min-height:200px;
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

        #tambahPelatihanModal .modal-dialog{
          max-width:70%;
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
@foreach($produk as $datas)
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-6 col-12 desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito">{{$datas->nama_produk}}</h1>
                <p class="text-white nunito"></p>                
            </div>
        </div>   
</section>

<section id="alur">
    <div class="container">
        <div class="row card-alur-wrapper">                    
            <div class="col-md-8">
                <div class="card-alur desc">

                  <p style="margin-top:54px;">Diproduksi Oleh :</p>
                  <h2 class="nunito"><strong>BUMDES {{$datas->nama_bumdes}}</strong></h2>
                  <br>
                  <p><strong>Deskripsi Produk :</strong></p>
                  <p>{{$datas->deskripsi_produk}}</p>
                  <br>
                  <p><strong>Di Publikasikan :</strong>&nbsp; {{$datas->created_at}}</p>
                  <br>
                  <!-- <p><strong>Anggota Bumdes :</strong>&nbsp;</p>
                  <p>Adam Maulana Dzikri, Syakir Daulay, Yessiana Ihda, Yolanda</p>
                  <br> -->
                  <p><strong>Harga:</strong>&nbsp; <span class="badge badge-warning">{{$datas->harga}}</span></p>
                  </div>
            </div>      
            <div class="col-md-4">
              <div class="card-alur photo-produk">
                  <img src="{{asset('cover_produk/'.$datas->foto_produk)}}" class="w-100" alt="">
                  <p>
                    Kelengkapan Produk :
                  </p>
                  <div class="row kelengkapan-produk">
                    <div class="col-lg-4"><a class="btn btn-success"><span class="fa fa-video"></span>&nbsp;Video Profile</a></div>
                    <div class="col-lg-4"><a class="btn btn-primary"><span class="fa fa-book"></span>&nbsp;Booklet</a></div>
                    <div class="col-lg-4"><a class="btn btn-warning"><span class="fa fa-game"></span>AR</a></div>                    
                  </div>
              </div>                
            </div>      
        </div>  
                
        <div class="row profil-bumdes">
            <div class="row profil-wrapper col-lg-8 col-md-8 col-12"> 
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pelatihan" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Pelatihan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pesan-produk" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Pemesanan Produk</a>
              </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pelatihan" role="tabpanel" aria-labelledby="pills-home-tab">              
                  <button class="btn btn-success float-right" data-toggle="modal" data-target="#tambahPelatihanModal">Tambah Pelatihan &nbsp;<span class="fa fa-group"></span></button>
                  <h2 class="mb-2 ml-3 mt-1">
                    Pelatihan Yang Diadakan <br>
                    <small>Berikut ini adalah pelatihan pelatihan yang diadakan untuk</small>
                  </h2>  
                  
                  <div class="row col-md-12 col-lg-12 col-sm-12 col-12">
                  @foreach($pelatihan as $data)
                    <div class="col-lg-6 col-md-6 col-12">                       
                      <div class="card-pelatihan">
                          <div class="cover-card">
                            <img src="{{asset('cover_pelatihan/'.$data->foto_cover)}}" alt="">
                          </div>
                          <div class="caption-card">                      
                            <a class="enroll" href="{{url('/dashboard_detail_pelatihan/'.$data->id)}}">
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
        </div>
    </div>  
</section>

@endsection
<!-- modal tambahPotensiModal -->
<div class="modal fade" id="tambahPelatihanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tabah Produk Potensi Desa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{url('/tambahPelatihan')}}" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_produk" value="{{$datas->produk_id}}">
      <div class="modal-body">
            {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>Judul Pelatihan</label>
                <input type="text" required="required" name="judul_pelatihan" class="form-control">
              </div>
              <div class="form-group">
                <label>Deskripsi Pelatihan</label>
                <textarea name="deskripsi_pelatihan" id="" required="required" class="form-control" rows="6"></textarea>
              </div>
              <div class="form-group">
                <label>Mentor </label>
                <input type="text" name="mentor" class="form-control">       
              </div>
            </div>
            <div class="col-lg-6">
                <center>
                    <img src="{{asset('assets/images/noimage.png')}}" alt="" style="height:200px" id="img-prev">
                </center>
                <div class="form-group">                
                    <label for="foto-pelatihan" class="btn btn-warning"><span class="fa fa-camera"></span>&nbsp; Pilih Cover Pelatihan... </label>
                    <input type="file" class="d-none" id="foto-pelatihan" name="foto_cover" required="required">
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
@endforeach    
<!-- end of tambahPotensiModal -->
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

        $("#foto-pelatihan").change(function(){
            readURL(this,'#img-prev');
        });        
    });
</script>
@endsection