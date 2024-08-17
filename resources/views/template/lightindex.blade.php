<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="{{asset('assets/css/light-navbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.css')}}">
    @yield('css')
    <title>IV Lab</title>
    
  </head>
  <body>
  @include('template/lightheader')
  @yield('content')
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init();
        $("#search-icon").click(function() {
          $(".nav").toggleClass("search");
          $(".nav").toggleClass("no-search");
          $(".search-input").toggleClass("search-active");
        });

        $('.menu-toggle').click(function(){
          $(".nav").toggleClass("mobile-nav");
          $(this).toggleClass("is-active");
        });

        var $w = $(window).scroll(function(){
            var targetOffset = $("body").offset().top;
            if ( $w.scrollTop() > targetOffset ) {   
                $('#myNavbar').css({"visibility":"hidden"});           
                $('#myDarkNavbar').css({"visibility":"visible"});           
            } else {
              $('#myNavbar').css({"visibility":"visible"});   
              $('#myDarkNavbar').css({"visibility":"hidden"});
            }
        });
</script>
    @yield('js')
  </body>