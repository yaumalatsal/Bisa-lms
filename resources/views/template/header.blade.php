<div class="nav-wrapper">
  <!-- <div class="grad-bar"></div> -->
    <nav id="myNavbar">
    <div class="navbar">
        <img src="{{asset('assets/images/logo.png')}}" class="brand" alt="Company Logo">
        <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
        </div>
        <ul class="nav no-search">
        <li class="nav-item"><a href="#">Home</a></li>
        <li class="nav-item"><a href="#">Tentang </a></li>
        <li class="nav-item"><a href="{{url('/shadesa')}}">Shadesa</a></li>
        <li class="nav-item"><a href="{{url('/pendaftaran')}}">Pendaftaran</a></li>
        <li class="nav-item">
            @if(!Session::has('id_bumdes'))
            <a href="{{url('/login')}}"><button class="btn bt-linear">Masuk</button></a>
            @else
            <a href="{{url('/dashboard')}}"><button class="btn bt-linear">Dashboard</button></a>
            @endif
        </li>
             
        </ul>
        </div>
    </nav>
    <nav id="myDarkNavbar">
    <div class="navbar">
        <img src="{{asset('assets/images/logo.png')}}" class="brand" alt="Company Logo">
        <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
        </div>
        <ul class="nav no-search">
        <li class="nav-item"><a href="#">Home</a></li>
        <li class="nav-item"><a href="#">Tentang </a></li>
        <li class="nav-item"><a href="{{url('/shadesa')}}">Shadesa</a></li>
        <li class="nav-item"><a href="{{url('/pendaftaran')}}">Pendaftaran</a></li>
        <li class="nav-item">
            @if(!Session::has('id_bumdes'))
            <a href="{{url('/login')}}"><button class="btn bt-linear">Masuk</button></a>
            @else
            <a href="{{url('/dashboard')}}"><button class="btn bt-linear">Dashboard</button></a>
            @endif
        </li>
             
        </ul>
        </div>
    </nav>
  </div>