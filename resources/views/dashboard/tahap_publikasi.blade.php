@section('title-page')
    Step 5 : Membuat Poster dan Video Produk
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:75%;
        }
        
        #video-area iframe{
            width:100%;
            height:400px;
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
                    <div class="row p-4">
                        <div class="col-md-5">
                            <center><img src="{{asset('assets/images/ilustration/step/publis.gif')}}" style="width:60%" class="m-5" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <h2>Selamat Datang di Tahap Publikasi Produk</h2>
                            <p>Dalam tahap ini, dilakukan pembuatan poster dan video produk, 
                                dengan tujuan untuk mempublish konsep produk yang akan dibuat agar dapat dimengerti oleh 
                                semua kalangan. Dalam pembuatan video dan poster dapat memanfaatkan bahan dari busines model canvas 
                                dan UI Design yang pernah dibuat di tahap sebelumnya.
                                <br> <br>
                                <a class="btn btn-warning">Materi Publikasi Produk <i class="fas fa-book"></i> </a>
                                <a href="{{url('/submitPublikasi')}}" class="btn btn-primary">Submit Progress <i class="fas fa-arrow-alt-circle-right"></i></a>
                            </p>                         
                        </div>
                    </div>               
                </div>
            </div>            
        </div>    
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
               @if($countVideo == 0)
                <div class="card-body">
                    <div class="row">
                        <h3>Tugas Video Produk</h3>
                        <p>
                            Berikut contoh video produk yang sudah terpublikasi di Internet : <br>
                        </p>             
                        <br>           
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/MEOn5GX_-hU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="row mt-3 p-5">
                        <p>
                            <ol>
                                <li>Buat video produkmu semaksimal mungkin</li>
                                <li>Apabula hipster masih kesulitan dalam membutanya. Dapat mempelajari dengan mengikuti link ini <a class="btn btn-xs btn-warning"><i class="fas fa-play"></i>&nbsp;Materi Pembelajaran UI Design dan Protoyping  </a></li>
                                <li>Upload video yang telah kamu buat pada platform YouTube</li>
                                <li>Upload <strong>Embed Link</strong> pada form di bawah ini</li>
                            </ol>
                        </p>
                        <form action="{{url('/setVideo')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <label for="" style="font-size:12px;"> Link Video Produk</label>
                            <br>  
                            <input type="text" name="link_video" id="" class="form-control" placeholder="Link Embed Youtube">
                            <br>
                            <button class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
               @else
                    @foreach($dataVideo as $datas)
                    <div class="card-body">
                        <div class="row">
                            <h3>Tugas Video Produk</h3>

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Video Sudah Terupload.</strong> Kamu harus submit progress agar mentor dapat mereview videomu. Klik <strong>Edit Link</strong> apabila ingin mengganti Embed Code Video <br><br>
                            <button data-video="{{$datas->link_video}}"class="btn btn-warning" id="btn-editVideo" data-bs-toggle="modal" data-bs-target="#modalEditVideo">Edit Link Video <span class="fas fa-edit"></span></button>
                            </div>

                            <p>Berikut adalah video produkmu :</p>
                            <div id="video-area">
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                @if($countPoster == 0)
                <div class="card-body">
                    <div class="row">
                    <h3> Tugas Poster Produk</h3>
                        <p>
                            Berikut adalah contoh poster produk yang bergerak di bidang jasa konultan bisnis: <br>
                        </p>  
                        <center>
                            <img class="w-100" src="https://unblast.com/wp-content/uploads/2020/01/Mobile-App-Promotion-Flyer-Template.jpg" alt="">
                        </center>
                    </div>  
                    <div class="row p-3">
                        <p>
                            <ol>
                                <li>Buat video produkmu sekreatif mungkin</li>
                                <li>Tools yang digunakan bebas (Adobe Ilustration, Adobe Photshop, Corel Draw, Figma, dll)</li>
                                <li>Apabila hipster masih kesulitan dalam membuatnya. Dapat mempelajari dengan mengikuti link ini <a class="btn btn-xs btn-success text-white"><i class="fas fa-play"></i>&nbsp;Materi Pembelajaran Video dan Poster Produk</a></li>
                                <li>Ekspor poster dengan ukuran A3 dalam format JPG                </li>
                                <li>Upload file poster pada form di bawah ini ( maksimal ukuran poster adalah 500kb )</li>
                                <li><strong>PENGINGAT : </strong> Pastikan hipster tetap menyimpan file project dari poster yang telah dibuat</li>
                            </ol>  
                            <form action="{{url('/setPoster')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <input type="file" name="poster_produk" class="form-control" method="post">
                                <br>
                                <button class="btn btn-primary">Simpan</button>
                            </form>
                        </p>
                    </div>
                </div>
                @else
                    @foreach($dataPoster as $poster)                            
                    <div class="card-body">
                        <div class="row">
                            <h3> Tugas Poster Produk</h3>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Video Sudah Terupload.</strong> Kamu harus submit progress agar mentor dapat mereview videomu. Klik <strong>Edit Link</strong> apabila ingin mengganti Embed Code Video <br><br>
                            <button data-poster="{{$poster->poster_produk}}"class="btn btn-warning" id="btn-editVideo" data-bs-toggle="modal" data-bs-target="#modalEditPoster">Edit Poster <span class="fas fa-edit"></span></button>
                            </div>
                            <br>
                            <img src="{{asset('poster_produk/'.$poster->poster_produk)}}" alt="">
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>


<!-- modal edit video -->
<div class="modal fade" id="modalEditVideo" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Edit Embed Code Video Produk</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/setVideo')}}" method="post" >
            {{csrf_field()}}   
            <label for="" style="font-size:12px;">Embed Code</label>
            <br> 
            <input type="text" name="link_video" id="ed-link" class="form-control">
            <br>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Batalkan</button>
        </form>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- modal edit poster -->
<div class="modal fade" id="modalEditPoster" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Edit Poster</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/setPoster')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}   
            <label for="" style="font-size:12px;">File Poster</label>
            <br> 
            <input type="file" name="poster_produk"  class="form-control" required="required">
            <br>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Batalkan</button>
        </form>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- end of modal edit poster -->

@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
        // $("#jadwalTabel").DataTable({
        //   "responsive": true,
        //     "autoWidth": false,
        // });
        
        @if($countVideo != 0 )
            $("#video-area").html('@php echo $playerVideo @endphp');
        @endif

        $("#btn-editVideo").click(function(){
           var link_video = $(this).data("video");
           $("#ed-link").val(link_video);
        });
    });
</script>
@endsection
