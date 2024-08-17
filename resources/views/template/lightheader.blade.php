<div class="nav-wrapper">
  <!-- <div class="grad-bar"></div> -->
    <nav id="lightNavbar">
    <div class="navbar">
        <img src="{{asset('assets/images/darklogo.png')}}" class="brand" alt="Company Logo">
        <div class="menu-toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
        </div>
        <ul class="nav no-search">
        <li class="nav-item"><a href="/">Home</a></li>
        <li class="nav-item"><a href="/">Tentang </a></li>
        <li class="nav-item"><a href="{{url('/shadesa')}}">Shadesa</a></li>
        <li class="nav-item"><a href="{{url('/pendaftaran')}}">Pendaftaran</a></li>
        @if(!Session::has('id_bumdes'))
        <li class="nav-item"><a href="{{url('/login')}}">
            <button class="btn bt-main">Masuk</button>
          </a>
        </li>
        @else
        <li class="nav-item"><a href="{{url('/dashboard')}}">
            <button class="btn bt-main">Dashboard</button>
          </a>
        </li>        
        @endif            
             
        </ul>
        </div>
    </nav>
  </div>