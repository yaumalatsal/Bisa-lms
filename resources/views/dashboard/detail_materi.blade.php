@section('title-page')
Detail Materi
@endsection
@section('css')
<style>
.video-player{
    min-height:30vh;
}

#materi-area iframe{
    width:100%;
    height:400px;
}
</style>
@endsection
@extends('dashboard_template/index')
@section('content')
<div class="container-fluid">
    <div>
        <div class="row">
            <div class="col-md-12">
                @foreach($materi as $data)
                <div class="card" id="materi-area">
                    <div class="video-area"></div>
                    <div class="card-body">
                        <h3>{{$data->judul_pelatihan}}</h3>
                        <p>{{$data->caption}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(function(){
        $(".video-area").html('@php echo $playervideo @endphp');        
    });
</script>
@endsection