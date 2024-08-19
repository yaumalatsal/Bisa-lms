@section('title-page')
    Detail Poin BMC
@endsection

@section('css')
<style>
    .card-step{
        min-height:350px;
    }
    .card-step .deskripsi-step{
        height:90px;
    }
</style>
@endsection

@extends('investor/template/index')
@section('content')
<div class="container-fluid">
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="col-md-12">
                            <br>
                            @foreach($getmaster as $masterbmc)
                            <h2>{{$masterbmc->judul}}</h2>
                            <p>
                                {{$masterbmc->deskripsi}}    
                            <br>
                                <!-- <a href="{{url('/submitDeck')}}" class="btn btn-primary">Submit Progress <i class="fas fa-arrow-alt-circle-right"></i></a> -->
                            </p>                         
                            @endforeach
                            <p>
                                
                            <ul>
                                @foreach($getResult as $bmc)
                                <li>{{$bmc->jawaban}}</li>    
                                @endforeach
                            </ul>
                                <button id="back-button" class="btn btn-warning">
                                    <i class="fas fa-chevron-left"></i>&nbsp; Kembali ke Menu BMC
                                </button>
                            </p>
                        </div>
                    </div>               
                </div>
            </div>            
        </div>    
    </div>
    <br>
    <!-- <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pelatihan Yang Diikuti</h5>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection
@section('js')
<script>
    $(function(){
        $("#back-button").click(function(){
            history.back(1);
        });
    });
</script>
@endsection