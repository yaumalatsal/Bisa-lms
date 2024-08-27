
@extends('template/blankindex')
@section('css')
    <style>
        #cover-page{
            margin:0px;
            width:100%;
            overflow-x:hidden;
            min-height:100vh;
            padding-top:20vh;
            background-image: linear-gradient(to right, #03192E , #153A5C);
        }

        #cover-page h1{
            color:white;
            font-size:60px;
            font-weight:700;
        }
        #cover-page .iso{
            width:100%;
            margin-top:3%;
        }
        #cover-page .desc{
            padding:1% 10%;
        }
        #cover-page .desc .btn{
            padding:10px 25px;
        } 

        #cover-page .login-box{
            width:100%;            
            margin-top:15%;
            margin:2%;
            padding:5%;
            background-color:#ffff;
            border-radius:10px;
        }

        #cover-page .login-box label{
            font-weight:700;
            color:var(--sblue);
        }
        #cover-page .login-box .label-box{
            width:50%;
            background-color:#ffff;
            padding:20px;
            font-family:nunito;
            margin-top: -61px;
            margin-left: -33px;
            font-weight:700;
            border-radius:10px;
            text-align:center;

        }

        
        /* Responsive */

        @media only screen and (max-width: 720px) {  
            #cover-page{
                min-height:100vh;
                padding-top:10vh
            } 
            #cover-page .iso{
                display:none;
            }
            #cover-page .desc{
                text-align:center;                
            }
            #cover-page .desc h1{
                font-size:40px; 
                margin-bottom:5vh;               
            }
            #cover-page .desc p{
                display:none;
            }
            #cover-page .desc .btn{
                display:none;
            }
            #cover-page .login-box{
                width:80%;
                margin:5% 10%;                                
                background-color:#ffff;
                border-radius:10px;
            }
            #cover-page .login-box .label-box{
            width:50%;
            background-color:#ffff;
            padding:20px;
            font-family:nunito;
            margin-top: -61px;
            margin-left: -18px;
            font-weight:700;
            border-radius:10px;
            text-align:center;

        }

        }
    </style>
@endsection
@section('content')
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-5 col-12 hidden-xs desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito">IN<span class="main-text">CUBE<span></h1>
                <p class="text-white nunito">
                BISa  adalah platform untuk menginkubasi bisnis siswa pada mata pelajara Produk Kreatif dan Kewirausahaan
                </p>
                <a href="{{url('/login')}}" class="btn bt-linear nunito">Masuk Akun</a>
            </div>
            <div class="col-lg-6 col-12">
                <div class="login-box">
                    <div class="label-box">Pendaftaran Siswa</div>
                    <br>
                    <form action="{{url('/reg')}}" method="post">
                    {{csrf_field()}}    
                    <div class="form-group">
                        <label class="nunito">Nama Siswa</label>
                        <input required="required" type="text" name="nama_bumdes" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="nunito">Nomor Induk</label>
                        <input required="required" type="text" name="nis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="nunito">Tanggal Lahir</label>
                        <input required="required" type="date" name="ttl" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="nunito">Password</label>
                        <input required="required" type="password" name="password" class="form-control">
                    </div>                    
                    <button type="submit" class="btn bt-main w-100">Daftar Sekarang</button>
                    </form>
                    <br><br>
                    <center>
                    <small>Lupa Kata Sandi ? <a class="text-primary">Klik Disini</a></small>
                    </center>
                </div>
            </div>
        </div>   
</section>

@endsection