@section('title-page')
    Step 4 : Membuat Logo Brand dan  Prototyping
@endsection
@section('css')
    <style>
        

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
                            <div class="text-center"><img src="{{asset('assets/images/ilustration/step/proto.gif')}}" style="width:60%" class="m-5" alt=""></div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-5"> <strong>Selamat Datang Tahap di Prototyping dan Branding Logo </strong></h2>        
                            <p>Dalam tahap ini, silahkan membuat protoyping dari produk dalam bisnis ini.Dalam pembuatan prototyping ini yang digunakan 
                            adalah Figma.<</p>
                            <x-action-form :action="url('/submitProto')" class="btn btn-primary text-white"
                                confirm="Kirim progress prototype?">Submit Progress <i class="fas fa-arrow-circle-right"></i></x-action-form>
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
                                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalMateriProto"><i class="fas fa-play"></i> Pembelajaran UI Design dan protoyping  </button>                         
                                <a href="https://dribbble.com/search/ui" target="_blank" class="btn btn-secondary" ><i class="fas fa-book"></i> Referensi UI Design</a>                         
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
                            <label for="f-link_figma" style="font-size:12px;">Shared Link Figma</label>
                            <br> 
                            <input type="text" name="link_figma" id="f-link_figma" class="form-control" required="required">
                            <br>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        @else
                        <div class="m-1 figma-area">
                            <br>
                            @foreach($dataFigma as $figma )
                            <h3>Berikut Link Prototype Figma dari produkmu : 
                            <button data-bs-target="#modalEditLink" id="bt-edit" data-bs-toggle="modal" class="btn btn-secondary" 
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
                        <button data-bs-toggle="modal" data-bs-target="#modalMateri" class="btn btn-secondary"><i class="fas fa-play"></i> Video Pembelajaran Logo Produk</button>
                        <a href="https://id.pinterest.com/fangchichang/company-logo-reference/" target="_blank" class="btn btn-secondary"><i class="fas fa-book"></i>&nbsp; Referensi Logo Produk </a>
                        <br> <br>
                    </p>

                    @if(session('status'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('status')}}
                                        
                    </div>
                    @endif
                    
                    @if($countLogo == 0)
                    Jangan lupa uplad foto dari logomu sebagai bukti progress kepada mentor
                    <div class="text-center">
                        <img class="w-70" src="{{asset('assets/images/noimage.png')}}" alt="">
                    </div>
                    <form action="{{url('/setLogo')}}" method="post" enctype='multipart/form-data'>
                    {{csrf_field()}}  
                        <label class="form-label" for="logo-produk-baru">Berkas logo (PNG, JPG atau WebP)</label>
                        <input type="file" id="logo-produk-baru" name="logo_produk" class="form-control"
                            required accept=".jpg,.jpeg,.png,.webp">
                        <label class="form-label mt-3" for="logo-deskripsi-baru">Deskripsi singkat dan makna logo</label>
                        <textarea id="logo-deskripsi-baru" name="deskripsi" class="form-control" rows="4"></textarea>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                    @else
                    <div class="mt-3">
                        @foreach($dataLogo as $logo)
                        <h4>Logo yang sudah terupload :  
                            <button data-bs-target="#modalEditLogo" id="bt-edit-logo" data-bs-toggle="modal" class="btn btn-secondary"                             
                            data-desc-logo="{{$logo->deskripsi}}"> 
                            Edit Logo &nbsp;<i class="fas fa-edit"></i>
                            </button>
                        </h4>
                        <div class="text-center">
                        <img class="m-5" style="width:200px" id="logo-awal-produk" src="{{asset('/logo_produk/'.$logo->logo_produk)}}" alt="">
                        </div>
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
            <label for="ed-link" style="font-size:12px;">Shared Link Figma</label>
            <br> 
            <input type="text" name="link_figma" id="ed-link" class="form-control" required="required">
            <br>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </form>
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
        <h3 class="modal-title" id="ed-pertanyaan-2">Edit Link Prorotype Figma</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/setLogo')}}" method="post" enctype='multipart/form-data'>
            {{csrf_field()}}   
            <img src="" id="ed-logo" alt="" style="width:200px;">
            <br><br>
            <label class="form-label" for="ed-logo-file">Berkas logo (PNG, JPG atau WebP)</label>
            <input type="file" id="ed-logo-file" name="logo_produk" class="form-control"
                required accept=".jpg,.jpeg,.png,.webp">
            <label class="form-label mt-3" for="ed-deskripsi-logo">Deskripsi singkat dan makna logo</label>
            <textarea id="ed-deskripsi-logo" name="deskripsi" class="form-control" rows="4" required></textarea>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
            </div>
        </form>
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
        <h3 class="modal-title" id="ed-pertanyaan-3">Pentingnya Logo Produk</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <iframe width="100%" height="400px" src="https://www.youtube.com/embed/gIcSQOiUxXc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <div class="modal-footer">                
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>    
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
        <h3 class="modal-title" id="ed-pertanyaan-4">Video Pembelajaran Prototyping Produk dengan Figma</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <iframe width="100%" height="450px" src="https://www.youtube.com/embed/195RY7jCuZg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <div class="modal-footer">                
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>    
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
