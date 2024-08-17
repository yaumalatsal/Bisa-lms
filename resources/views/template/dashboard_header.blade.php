@if(!Session::has('id_bumdes'))
    <script>
        window.location.href = "{{url('/login')}}"
    </script>
@endif
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
            <li class="nav-item"><a href="{{url('/dashboard')}}">Home</a></li>        
            <li class="nav-item"><a href="{{url('/sharing')}}">Sharing</a></li>        
            <li class="nav-item"><a href="{{url('/shadesa')}}">Shadesa</a></li>           
            <li class="nav-item">            
                <a href="{{url('/logout')}}"><button class="btn bt-linear">Keluar</button></a>            
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
            <li class="nav-item"><a href="{{url('/dashboard')}}">Home</a></li>        
            <li class="nav-item"><a href="{{url('/sharing')}}">Sharing</a></li>        
            <li class="nav-item"><a href="{{url('/shadesa')}}">Shadesa</a></li>           
            <li class="nav-item">            
                <a href="{{url('/logout')}}"><button class="btn bt-linear">Keluar</button></a>            
            </li>                      
        </ul>
        </div>
    </nav>
  </div>