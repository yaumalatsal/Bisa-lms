@section('title-page')
    Step 4 : Membuat Logo Brand dan  Prototyping
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
                        <div class="col-md-5">
                            <center><img src="{{asset('assets/images/ilustration/step/proto.gif')}}" style="width:60%" class="m-5" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-5"> <strong>Selamat Datang Tahap di Prototyping dan Branding Logo </strong></h2>        
                            <p>Dalam tahap ini, silahkan membuat protoyping dari produk dalam bisnis ini.Dalam pembuatan prototyping ini yang digunakan 
                            adalah Figma.<</p>
                            <a href="{{url('/submitProto')}}" class="btn btn-primary text-white"> Submit Progress &nbsp;<i class="fas fa-arrow-circle-right"></i> </a>
                        </div>    
                    </div>
        
                </div>
            </div>            
        </div>    
    </div>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    
                    <div class="row p-2">
                        <h3>Link Figma</h3>
                        <p style="font-size:15px;">
                        Dalam membuat UI Design sekaligus prototyping di alur inkubasi ini. Kita menggunakan 
                        tools protoyping yaitu <strong>Figma. </strong> <br>
                        Adapun langka langkah menggunakan Figma sebagai berikut : <br>
                        </p>
                        <div class="p-1" style="font-size:13px;">
                            <ol>
                                <li>Buka <a href="https://www.figma.com" class="badge rounded-pill bg-primary" target="_blank">www.figma.com</a></li>                        
                                <li>Arahkan cursor ke menu  <strong>Draft</strong> di sidebar menu kiri, hingga muncul tanda <strong>'+'</strong>. Dan klik tranda 
                                <strong>+</strong> , lalu pilih <strong>New Design File</strong> untuk membuat project design baru di figma</li>
                                <li>Pelajari Video dan Referensi berikut untuk mengawali design dan prototyping
                                <button class="btn  btn-warning" data-bs-toggle="modal" data-bs-target="#modalMateriProto"><i class="fas fa-play"></i> Pembelajaran UI Design dan protoyping  </button>                         
                                <a href="https://dribbble.com/search/ui" target="_blank" class="btn  btn-success text-white" ><i class="fas fa-book"></i> Referensi UI Design</a>                         
                                </li>        
                                @foreach($dataMentor as $mentor)                
                                <li> Invite email mentormu, pada project figma, Adapun email mentormu adalah <br><h3 class="badge rounded-pill bg-secondary">{{$mentor->email}}</h3></li>
                                @endforeach
                                <li> Jangan lupa juga menyematkan link Figma dari produkmu pada form di bawah ini</h3></li>
                            </ol>         
                        </div>

                        @if($countFigma == 0)
                        <div class="m-1">
                            <form action="{{url('/setFigma')}}" method="post" >
                            {{csrf_field()}}   
                            <label for="" style="font-size:12px;">Shared Link Figma</label>
                            <br> 
                            <input type="text" name="link_figma" id="" class="form-control" required="required">
                            <br>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        @else
                        <div class="m-1 figma-area">
                            <br>
                            @foreach($dataFigma as $figma )
                            <h3>Berikut Link Prototype Figma dari produkmu : 
                            <button data-bs-target="#modalEditLink" id="bt-edit" data-bs-toggle="modal" class="btn btn-success text-white" 
                            data-figma=" {{$figma->link_figma}}"> 
                                Edit Link <i class="fas fa-edit"></i> 
                            </button></h3>
                            <a href="{{$figma->link_figma}}">    
                                <div class="alert alert-warning" id="mylink">    
                                    {{$figma->link_figma}}
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">

                
                <div class="card-body">
                    <h3>Logo Produk</h3>
                    <p>Logo akan menjadi identitas yang pertama di lihat dari produkmu. Ada banyak sekali tools 
                        yang dapat digunakan untuk memuat logo yang menarik. Mulai dari Adobbe Ilustrator, Figma, Coreldraw, dan sejenisnya.
                        Untuk memudahkan mengawali pembuatan logo, <strong>Hipster</strong> dalam tim mu dapat mengakses
                        referensi ini <br>
                        <button data-bs-toggle="modal" data-bs-target="#modalMateri" class="btn btn-success text-white"><i class="fas fa-play"></i> Video Pembelajaran Logo Produk</button>
                        <a href="https://id.pinterest.com/fangchichang/company-logo-reference/" target="_blank" class="btn btn-warning"><i class="fas fa-book"></i>&nbsp; Referensi Logo Produk </a>
                        <br> <br>
                    </p>

                    @if(session('status'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('status')}}
                                        
                    </div>
                    @endif
                    
                    @if($countLogo == 0)
                    Jangan lupa uplad foto dari logomu sebagai bukti progress kepada mentor
                    <center>
                        <img class="w-70" src="{{asset('assets/images/noimage.png')}}" alt="">
                    </center>
                    <form action="{{url('/setLogo')}}" method="post" enctype='multipart/form-data'>
                    {{csrf_field()}}  
                        <input type="file" name="logo_produk" class="form-control" required="required" accept=".jpg,.png">
                        <label for="deskripsi">Deskripsi singkat dan Makna logo :</label>
                        <textarea name="deskripsi" class="form-control" id="" cols="30" rows="4"></textarea>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                    @else
                    <div class="mt-3">
                        @foreach($dataLogo as $logo)
                        <h4>Logo yang sudah terupload :  
                            <button data-bs-target="#modalEditLogo" id="bt-edit-logo" data-bs-toggle="modal" class="btn btn-success text-white"                             
                            data-desc-logo="{{$logo->deskripsi}}"> 
                            Edit Logo &nbsp;<i class="fas fa-edit"></i>
                            </button>
                        </h4>
                        <center>
                        <img class="m-5" style="width:200px" id="logo-awal-produk" src="{{asset('/logo_produk/'.$logo->logo_produk)}}" alt="">
                        </center>
                        <br>
                        Deskripsi singkat Logo :
                        <div class="alert alert-success">
                            {{$logo->deskripsi}}
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>



<!-- modal edit link -->
<div class="modal fade" id="modalEditLink" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Edit Link Prorotype Figma</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/setFigma')}}" method="post" >
            {{csrf_field()}}   
            <label for="" style="font-size:12px;">Shared Link Figma</label>
            <br> 
            <input type="text" name="link_figma" id="ed-link" class="form-control" required="required">
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
<!-- end of modal edit link -->

<!-- modal edit logo -->
<div class="modal fade" id="modalEditLogo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Edit Link Prorotype Figma</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/setLogo')}}" method="post" enctype='multipart/form-data'>
            {{csrf_field()}}   
            <img src="" id="ed-logo" alt="" style="width:200px;">
            <br><br>
            <input type="file" name="logo_produk"  class="form-control" required="required" accept=".png,.jpeg">
            <label for="deskripsi">Deskripsi singkat dan Makna logo :</label>
            <textarea name="deskripsi" class="form-control" id="ed-deskripsi-logo" required="required" cols="30" rows="4"></textarea>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Batalkan</button>
        </form>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- end of modal edit link -->

<!-- modal edit logo -->
<div class="modal fade" id="modalMateri">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Pentingnya Logo Produk</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <iframe width="100%" height="400px" src="https://www.youtube.com/embed/gIcSQOiUxXc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <div class="modal-footer">                
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Tutup</button>    
            </div>
        </div>
    </div>
  </div>
</div>
<!-- end of modal edit link -->

<!-- modal edit logo -->
<div class="modal fade" id="modalMateriProto">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Video Pembelajaran Prototyping Produk dengan Figma</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <iframe width="100%" height="450px" src="https://www.youtube.com/embed/195RY7jCuZg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <div class="modal-footer">                
                <button type="button"  class="btn btn-danger text-white" data-bs-dismiss="modal">Tutup</button>    
            </div>
        </div>
    </div>
  </div>
</div>
<!-- end of modal edit link -->


@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
        $("#bt-edit").click(function(){
            var linkFigma   = $(this).data('figma');
            $('#ed-link').val(linkFigma);
        });


        $("#bt-edit-logo").click(function(){
            var img = $('#logo-awal-produk').attr('src');
            var desk = $(this).data('desc-logo');
            $('#ed-deskripsi-logo').val(desk);
            $('#ed-logo').attr('src',img);
        }); 
    });
</script>
@endsection
