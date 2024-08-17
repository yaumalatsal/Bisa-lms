
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
@foreach($pelatihan as $datas)
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-6 col-12 desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito">{{$datas->nama_pelatihan}}</h1>
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
                  <p>{{$datas->deskripsi}}</p>
                  <br>
                  <p><strong>Di Publikasikan :</strong>&nbsp; {{$datas->created_at}}</p>
                  <br>
                  <!-- <p><strong>Anggota Bumdes :</strong>&nbsp;</p>
                  <p>Adam Maulana Dzikri, Syakir Daulay, Yessiana Ihda, Yolanda</p>
                  <br> -->
                  <!-- <p><strong>Harga:</strong>&nbsp; <span class="badge badge-warning">{{$datas->harga}}</span></p> -->
                  <div class="row profil-bumdes">
                      <div class="row profil-wrapper col-lg-12 col-md-12 col-12"> 
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="pelatihan" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Materi</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="peserta" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Peserta</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="ujian" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Pengajuan Ujian</a>
                          </li>
                        </ul>
                        <div class="tab-content w-100" id="pills-tabContent">
                          <div class="tab-pane fade show active" id="pelatihan" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div>

                            </div>              
                              <button class="btn btn-success float-right" data-toggle="modal" data-target="#tambah-materi">Tambah Materi&nbsp;<span class="fa fa-group"></span></button>
                              <h2 class="mb-2 ml-3 mt-1">
                                Daftar Video Pelatihan <br>
                                <small>Berikut ini adalah pelatihan pelatihan yang diadakan untuk</small>
                              </h2>
                              <br>
                              <table class="table table-stripped">
                                  <thead>
                                    <th>No</th>
                                    <th>Judul Materi</th> 
                                    <th></th>                                   
                                  </thead>
                                  <tbody>
                                    @php $no = 1; @endphp                                     
                                    @foreach($video as $datavideo)
                                    <tr>
                                      <td>{{$no++}}</td>
                                      <td>{{$datavideo->judul_pelatihan}}</td>
                                      <td><a href="{{url('detail_materi/'.$datavideo->id_pelatihan.'/'.$datavideo->id)}}" class="btn-sm btn-success">Putar&nbsp;<span class="fa fa-play"></span></a></td>
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
            <div class="col-md-4">
              <div class="card-alur photo-produk">
                  <img src="{{asset('cover_pelatihan/'.$datas->foto_cover)}}" class="w-100" alt="">
                  <p>
                    Kelengkapan Produk :
                  </p>
                  <div class="row kelengkapan-produk">
                    <a href="#" class="btn btn-danger w-100"><span class="fa fa-trash"></span>&nbsp; Hapus Kursus Ini</a>                    
                  </div>
              </div>                
            </div>      
        </div>  
                          
    </div>  
</section>


<!-- modal tambahPotensiModal -->
<div class="modal fade" id="tambah-materi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Video Pembelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{url('/tambahMateri')}}" method="post" enctype="multipart/form-data">
        <div class="modal-body">
              {{csrf_field()}}
                <input type="hidden" name="id_pelatihan" value="{{$datas->id_pelatihan}}">
                <div class="form-group">
                  <label>Judul Materi</label>
                  <input type="text" required="required" name="judul_pelatihan" class="form-control">
                </div>
                <div class="form-group">
                  <label>Link Video</label>                  
                  <input type="text" required="required" name="link_video" class="form-control">
                </div>
                <div class="form-group">
                  <label>Materi Singkat</label>
                  <textarea name="caption" id="" required="required" class="form-control" rows="6"></textarea>
                </div>                                            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Tambah Materi <span class="fa fa-upload"></span></button>
        </div>
    </form>
    </div>
  </div>
</div>
@endforeach  
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
    });
</script>
@endsection