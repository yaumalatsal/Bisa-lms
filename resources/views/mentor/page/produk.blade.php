@extends('mentor/template/index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row p-4">
                        <div class="col-md-12">
                            <h3>Daftar Produk Inkubasi:</h3>
                            <p>Pilih nama produk:</p>
                            <div class="table-responsive">
                                <table class="table table-stripped" id="table-one">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Logo</th>
                                            <th>Nama Produk</th>
                                            <th>CEO</th>
                                            <th>Aksi</th>
                                            <th>Group Chat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($produk as $data)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                @if(empty($data->logo_produk))
                                                    <strong>
                                                        <p class="text-danger">Belum Ada Logo</p>
                                                    </strong>
                                                @else
                                                    <img src="{{asset('logo_produk/'.$data->logo_produk)}}" alt="logo_produk" style="width:100px;">
                                                @endif
                                            </td>
                                            <td>{{$data->nama_produk}}</td>
                                            <td>{{$data->nama_siswa}}</td>
                                            <td>
                                                <a href="{{url('/mentor/detail_produk/'.$data->product_id)}}" class="btn btn-primary">
                                                    Detail Produk &nbsp;
                                                    <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('mentor.page.groupchat',$data->product_id ) }}" class="btn btn-success">
                                                    Grup Chat &nbsp;
                                                    <i class="fas fa-comments"></i>
                                                </a>
                                            </td>
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
    </div>
    <br>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $("#table-one").DataTable();
    });
</script>
@endsection
