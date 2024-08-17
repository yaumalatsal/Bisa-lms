@section('title-page')
    Buat Tim
@endsection
@section('css')
    <style>
        .modal-dialog{
            max-width:50%;
        }

        .table-result{
            background-color:#ffff;
            font-size:14px
        }

        .member-area{
            padding:10px;
            background-color:#ededed; 
        }

        #PositionModal p{
            font-size:14px;
            margin-bottom:0px;
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
                    <div class="row p-2">
                    @if(@$countmember < 3)
                        <h3>Bentuk Tim Hebatmu !</h3>
                        
                        <P>
                            Dibalik bisnis yang bagus, ada tim yang hebat. 
                            Tentukan Tim mu untuk membangun bisnis ini.
                            Dalam atu tim terdapat 3 role :
                            <br>
                            1. Hustler : Penanggung Jawab Marketing dan Business. Hustler juga berposisi sebagai CEO
                            <br>
                            2. Hipster : Penanggung Jawab Design dan User Experience
                            <br>
                            3. Hacker : Penanggung Jawab Technology, Engineer, dan Developer.
                        </P>
                        <p class="text-danger">
                            <br>
                            Catatan : bagi anggota pembentuk team dan pendaftar produk, secara otomatis akan menjadi 
                            Hustler (CEO)
                        </p>    
                        <br><br>
                          
                            <h4>
                                <strong>Silahkan Cari Anggota Terbaikmu</strong>
                            </h4>
                            <div class="member-area">
                                
                                <form action="{{url('/cari_member')}}" method="post">
                                {{csrf_field()}}    
                                <div class="input-group mb-3">
                                @foreach($getproduk as $dataproduk)        
                                    <input type="hidden" value="{{$dataproduk->id}}" name="id_produk">
                                @endforeach
                                <input type="hidden" value="{{Session::get('id_siswa');}}" name="id_siswa">
                                <input type="number" name="nis" class="form-control" placeholder="Nomor Induk Siswa" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit"> <span class="fa fa-search"></span> Cari Anggota</button>
                                </div>
                                
                                
                            </form>
                                <?php $data = Session::get('data_member') ?>
                                <div class="table-responsive" style="width:100%;">
                                @if(isset($data))
                         
                                    <table class="table table-bordered table-result" style="width:100%">
                                        @foreach($data as $member)
                                            <tr>
                                                <td width="40%">{{$member->nama}}</td>
                                                <td width="40%">{{$member->nomor_induk}}</td>
                                                <td>
                                                    <button type="button" class="btn-tambah-member btn btn-success"
                                                        data-nama="{{$member->nama}}"
                                                        data-nis="{{$member->nomor_induk}}"
                                                        data-id="{{$member->id}}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#PositionModal" >
                                                        <span class="fa fa-plus"></span>
                                                        Tambahkan
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                
                                @endif
                                </div>
                                <?php $status = Session::get('status') ?>                            
                                @if(isset($status))
                                <div  style="width:100%" class="alert alert-primary" role="alert">
                                      {{$status}}
                                </div>
                                @endif
                            </div>
                            </div>
                            <br>
                    @else
                        <div class="col-md-5">
                            <center><img src="{{asset('assets/images/ilustration/step/team.gif')}}" style="width:60%" class="m-5" alt=""></center>
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-5">Tim Sudah Terbentuk</h2>
                            <p>Tim sudah terbentuk dengan formasi yang sudah optimal.<br> Klik <strong>Lanjutkan ke Pembuatan Profil Bisnis </strong> untuk menuju langkah selanjutnya. 
                                <br>Jika anda melanjutkan ke langkah selanjutnya, tim sudah tidak diubah lagi. Enjoy With Your Team.
                            </p>
                            <form action="/lock_team" method="post">
                            {{csrf_field()}}  
                            @foreach($getproduk as $dataproduk)
                            <input type="hidden" value="{{$dataproduk->id}}" name="id_produk">                                
                            @endforeach
                            <input type="hidden" value="{{Session('id_siswa')}}" name="id_siswa">                                

                                <button type="submit" class="btn btn-lg btn-info text-white">Lanjutkan ke Pembuatan Profil Bisnis &nbsp;<span class="fas chevron-right"></span></button>
                            </form>
                        </div>
                    @endif

                            @if(isset($status_hapus))
                            <div class="alert mt-5alert-warning alert-dismissible fade show" role="alert">
                                   <strong>Sukses Menghapus.</strong> Member terpilih sudah tidak menajadi bagian dari tim anda.
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th width="10%">No</th>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Posisi</th>
                                    <th width="20%">Action</th>
                                </tr>
                                @php 
                                $no = 1;
                                $extend_no = 2; 
                                @endphp

                                @foreach($getceo as $ceo)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$ceo->nama}}</td>
                                    <td>{{$ceo->nomor_induk}}</td>
                                    <td>Hustler (CEO)</td>
                                    <td></td>
                                </tr>
                                @endforeach

                                @foreach($getmember as $member)
                                <tr>
                                    <td>{{$extend_no++}}</td>
                                    <td>{{$member->nama}}</td>
                                    <td>{{$member->nomor_induk}}</td>
                                    <td>
                                        @if($member->position == 2)
                                            Hipster
                                        @else
                                            Hacker
                                        @endif
                                    </td>
                                    <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" 
                                            style="color:white"
                                            class="btn btn-danger btn-delete-member"
                                            data-id="{{$member->id}}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#DeleteModal" 
                                        ><span class="fas fa-window-close" ></span> Batalkan </button>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>  
                        </div>                
                    </div>               
                </div>
            </div>            
        </div>    
    </div>
</div>

<!-- Modal Add Anggota-->
<div class="modal fade" id="PositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Role Member</h5>
        
      </div>
      <div class="modal-body">
        <p><strong>Nama :</strong> <span class="nama-member"></span></p>
        <p><strong> Nomor Induk Siswa :</strong> <span id="nis-member"></span></p>
        <br>
        <p>Tentukan role (bagian) untuk memudahkan pembagian jobdesk dalam 
            pengembangan produkmu.
            <br>
            Jadikan <strong><span class="nama-member"></span></strong> sebagai :
        </p>
        <br>
        <form action="tambah_member" method="post" id="form_invite">
            {{csrf_field()}}  
            <select name="position" id="" class="form-control">
                @foreach($position as $data_posisi)
                <option value="{{$data_posisi->id}}">{{$data_posisi->posisi}}</option>
                @endforeach
            </select>
            @php $id_produk = 0;@endphp
            @foreach($getproduk as $dataproduk)
            @php $id_produk = $dataproduk->id @endphp
            @endforeach

            <input type="hidden" name="id_siswa" id="id_user">
            <input type="hidden" value="{{$id_produk}}" name="id_produk">

      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
        
      </div>
      <div class="modal-body p-5">
            <center>
                <h1>Anda Yakin Menghapus Member ini ?</h1>
                <a href="#" class="btn btn-success btn-lg text-white bt-confirm-delete clr-white">Ya</a>
                <button class="btn  btn-danger  btn-lg text-white"  data-bs-dismiss="modal" >Tidak</button>
            </center>
      </div>
        </form>
    </div>
  </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    $(function(){
        
        $(".btn-tambah-member").click(function(){
            var nama = $(this).data('nama');
            var nis = $(this).data('nis');
            var id = $(this).data('id');

            $(".nama-member").text(nama);
            $("#id_user").val(id);
            $("#nis-member").text(nis);
            $("#form-invite").attr('action','tambah_member');
        });

        $(".btn-delete-member").click(function(){
            var id = $(this).data('id');
            $(".bt-confirm-delete").attr("href","delete_member/"+id);
        });



    });
</script>
@endsection
