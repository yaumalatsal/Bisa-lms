
@extends('template/index')
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
            padding:5% 10%;
        }
        #cover-page .desc .btn{
            padding:10px 25px;
        } 

        #alur{
            min-height:80vh;   
            width:100%;                                
            margin-top:-2%;            
        }
        #alur .container{
            padding:5%;                         
            background-color:#fff;    
            border-radius:2px;        
        }

        #alur .alur-item{
            padding:2%;
        }
        #alur .alur-item img{
            width:60%;
        }
        #alur .alur-item h5{
            margin-top:20px;
        }

        #first-step h1{
            font-weight:700;
            font-size:37px;
        }

        #first-step a{
            padding:10px 30px;  
        }
        #first-step p{
            font-size:17px;  
        }

        #first-step img{
              width:70%;
        }

        
        #team{
            min-height:40vh;}
        #team .card-team{
            width:15%;
            text-align:center;
            display:inline-block;
            margin:2%;
        }
        #team .card-team h5{
            font-size:16px;
        }
        #team .card-team img{
            width:100%;
        } 
        
        /* Responsive */

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

            #alur{
                padding-top:7%;
            }
            #alur h2{
                font-size:25px;
                font-weight:400;
            }
            #alur .alur-item img{
                width:37%;
            }

            #first-step{
                padding:4%;
            }
            #team .card-team{
                width:100%;
                padding-left:20%;
                padding-right:20%;
            }

        }
    </style>
@endsection
@section('content')
<section  id="cover-page">    
        <div class="row">
            <div class="col-lg-6 col-12 desc"  data-aos="fade-up" data-aos-duration="1500">
                <h1 class="nunito">Innovation <br> Village <span class="main-text">Lab<span></h1>
                <p class="text-white nunito">
                Village Innovation Lab  adalah platform untuk memudahkan BUMDES menemukan objek usaha yang sesuai dengan potensi desa.
                </p>
                <a href="" class="btn bt-linear nunito">Daftar Sekarang</a>
            </div>
            <div class="col-lg-5 col-12 text-center">
                <img src="{{asset('assets/images/isometric.png')}}" class="iso"  data-aos="fade-up" data-aos-duration="1500"> 
            </div>
        </div>   
</section>

<section id="alur">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="nunito blue-text font-weight-bold">Alur Program Innovation Village Lab</h2>
                <small class="nunito">Platform ini akan membantu percepatan bisnis BUMDES hingga launching produk</small>
            </div>
            <div class="col-md-12 row mt-5 text-center">
                <div class="col-md-3 col-xs-12 text-center alur-item" data-aos="fade-up" data-aos-duration="1500"><img src="{{asset('assets/images/alur1.png')}}" alt=""><h5 class="nunito font-weight-bold">Penentuan Potensi Desa</h5></div>                            
                <div class="col-md-3 col-xs-12 text-center alur-item" data-aos="fade-up" data-aos-duration="1500"><img src="{{asset('assets/images/alur2.png')}}" alt=""><h5 class="nunito font-weight-bold">Sharing dan Mentoring</h5></div>                            
                <div class="col-md-3 col-xs-12 text-center alur-item" data-aos="fade-up" data-aos-duration="1500"><img src="{{asset('assets/images/alur3.png')}}" alt=""><h5 class="nunito font-weight-bold">Uji Coba Produk</h5></div>                            
                <div class="col-md-3 col-xs-12 text-center alur-item" data-aos="fade-up" data-aos-duration="1500"><img src="{{asset('assets/images/alur4.png')}}" alt=""><h5 class="nunito font-weight-bold">Launching Produk/Usaha</h5></div>                     
            </div>
        </div>
    </div>  
</section>

<section id="first-step">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 col-12" data-aos="fade-right" data-aos-duration="1500">
                <small class="nunito ">Tahap 1 : Penentuan Potensi Desa</small>
                <h1 class="nunito  blue-text">Temukan dan Isikan Potensi Yang Ada di Desamu</h1>
                <p class="nunito">Potensi yang ada di desa dapat berupa potensi alam maupunpotensi sumber daya manusia. Dalam tahap ini akan menjadi penentuan pada tahap selanjutnya yaitu  Mentoring</p>
                <br>
                <a href="" class="btn bt-linear">Isikan Potensi Desa</a>
                <br><br><br>
            </div>
            <div class="col-lg-4 text-center">
                <img src="{{asset('assets/images/ide.png')}}" data-aos="fade-left" data-aos-duration="1500">
                
            </div>
        </div>
        
        <div class="row mt-2 pb-5">
            <div class="col-lg-8 col-12">                
                <h1 class="nunito  blue-text">Puluhan Badan Usaha Milik Desa sudah tergabung</h1>
                <p class="nunito">Potensi yang ada di desa dapat berupa potensi alam maupunpotensi sumber daya manusia. Dalam tahap ini akan menjadi penentuan pada tahap selanjutnya yaitu  Mentoring</p>
                <br>                
            </div>
            <div class="col-lg-4 text-center">
                <a href="" class="btn bt-linear mt-5">Lihat Desa Terdaftar</a>
            </div>
        </div>
        <br><br>
    </div>
</section>

<section id="team">
    <div class="container">
        <center>
            <h1 class="nunito mb-7"><strong>Tim Pengembang<strong></h1>
        </center>
        <br><br><br>
       

        <div class="card-team">
            <img src="{{asset('assets/images/oki.png')}}" alt="">
            <h5 class="nunito mt-2 mb-0"><strong>Okki Aenur Diana</strong></h5>
            <p class="mt-0">Project Lead</p>
        </div>

        <div class="card-team">
            <img src="{{asset('assets/images/dam.png')}}" alt="">
            <h5 class="nunito mt-2 mb-0"><strong>Adam Maulana Dzikri</strong></h5>
            <p class="mt-0">Software Specialist</p>
        </div>

        <div class="card-team">
            <img src="{{asset('assets/images/yesi.png')}}" alt="">
            <h5 class="nunito mt-2 mb-0"><strong>Yessiana Ihda</strong></h5>
            <p class="mt-0">Project Associate</p>
        </div>

        <div class="card-team">
            <img src="{{asset('assets/images/icha.png')}}" alt="">
            <h5 class="nunito mt-2 mb-0"><strong>Icha Shivana</strong></h5>
            <p class="mt-0">Human Relation</p>
        </div>
        <div class="card-team">
            <img src="{{asset('assets/images/yol.png')}}" alt="">
            <h5 class="nunito mt-2 mb-0"><strong>Yolanda Dufa</strong></h5>
            <p class="mt-0">Financial Analyst</p>
        </div>
        <br>
        <br>
        <br>
    </div>
</section>
@endsection