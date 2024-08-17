@section('title-page')
    Step 6 : Membuat Pitch Deck
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
                    <div class="row p-4">
                        <div class="col-md-5">
                            <center><img src="{{asset('assets/images/ilustration/step/presen.gif')}}" style="width:80%" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <h2>Selamat Datang di Tahap Presentasi Produk ( Pitch Deck )</h2>
                            <p>Dalam tahap ini, dilakukan pembuatan file presentasi tentang produk dan konsep bisnis dari tim mu. Perumusan
                                file presentasi diperlukan untuk mengenalkan dan mempromosikan produk kita pada investor atau pun calon pelanggan.
                                <br> <br>
                                <a href="{{url('/submitDeck')}}" class="btn btn-primary">Submit Progress <i class="fas fa-arrow-alt-circle-right"></i></a>
                            </p>                         
                        </div>
                    </div>               
                </div>
            </div>            
        </div>    
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <div class="card-body">
                    <h3>Poin Poin Pitch Deck</h3>
                    <p>Dalam membuat suatu file presentasi ada beberapa poin 
                        inti yang bisa diterapkan agar file presentasi tidak terlalu panjang, tidak pula terlalu ringkas. 
                        Adapun 10 di rekomendasikan dalam Pitch Deck, sebagai berikut :  
                        <strong>
                            <ol>
                                <li>Problem ( Perumusan Masalah )</li>
                                <li>Solution ( Solusi yang ditawarkan untuk menjawab masalah )</li>
                                <li>Product Overview ( Gambaran singkat produk )</li>
                                <li>Market Size ( Ukuran pasar yang ditargetkan )</li>
                                <li>Traction</li>
                                <li>Competition</li>
                                <li>Business Model (Model Bisnis)</li>
                                <li>Market Strategies (Strategi Pemasaran)</li>
                                <li>Team Member ( Anggota Tim )</li>
                                <li>Funding Status( Rencana Pendanaan)</li>

                            </ol>
                        </strong>
                        <a href="#" class="btn btn-success">Materi dan Contoh Pitch Deck &nbsp;<i class="fas fa-book"></i> </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
        @if($countDeck != 0)
            @foreach($deck as $data)
            <div class="card">
                <div class="card-body">
                    <h3>File Presentasi</h3>
                    <p>Kamu sudah memgupload link Pitch Deckk dari Produk mu <br>
                        <button data-bs-target="#modalDeck" data-deck="{{$data->deck}}" id="editDeck" data-bs-toggle="modal"  class="btn btn-warning">Edit Link &nbsp;<i class="fas fa-edit"></i></button>
                    </p>
                    <p>Link :</p>
                    <div class="alert alert-success">
                        <a href="{{$data->deck}}" target="_blank">{{$data->deck}}</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body">
                    <h3>File Presentasi</h3>
                    <p>Silahkan upload link file presentasi agar mentor mu dapat melakukan review
                    pada tahap ini. 
                    <ol>
                        <li>Buatlah file baru pada Google Slide</li>
                        <li>Rancang dan buatkah file presentasimu sebaik mungkin pada file gogle slide mu tadi</li>
                        <li>Jika telah selesai, klik "Share" pada Google Slide, dan pastikan General Access nya ter setting " <strong>Anyone With the Link </strong>" untuk memudagkan mentor dalam mereview Pitch Deckmu </li>
                        <li>Klik <strong>Copy Link</strong> , dan isikan Link Google Slide pada form dibawah ini  </li>
                    </ol>
                    </p>
                    <form action="{{url('/setPitchDeck')}}" method="post">
                        {{csrf_field()}}
                        <label for="">Link Pitch Deck</label>
                        <input type="text" name="deck" class="form-control">
                        <br>
                        <button type="submit" class="btn btn-primary">Simpan <i class="fas fa-save"></i> </button>
                    </form>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>

<!-- modal edit video -->
<div class="modal fade" id="modalDeck" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="ed-pertanyaan">Edit Link Pitch Deck</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{url('/setPitchDeck')}}" method="post" >
            {{csrf_field()}}   
            <label for="" style="font-size:12px;">Link Google Slide</label>
            <br> 
            <input type="text" name="deck" id="ed-deck" class="form-control">
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
@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
        $("#editDeck").click(function(){
            var deck = $(this).data('deck');
            $("#ed-deck").val(deck);
        }); 
    });
</script>
@endsection
