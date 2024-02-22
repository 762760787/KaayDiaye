<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sama Boutique</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('build/assets/app.css')}}">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
  </head>
<body>
  
    <div class="container row-cols-md-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-info shadow p-1 mb-1 bg-light " style="text-transform: uppercase">
            <a class="navbar-brand ms-2" style="font-family: 'Times New Roman', Times, serif; font-size: 20px; font-weight: bold;" href="/"><img src="{{ asset('image/logo.png')}}" width="110px;" height="60px;"/></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav" style="font-family: 'Times New Roman', Times, serif; font-size: 18px;">
                <li class="nav-item active">
                  <a class="nav-link ms-5 active" href="/">Accueil <span class="sr-only"></span></a>
                </li>
                
               
                <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Apropos</a>
                </li>
                
                @guest
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('registration') }}"> <img
                    src="{{ asset('image/connexion.png')}}"
                    class="rounded-circle"
                    height="40"
                    alt=""
                    loading="lazy">  Inscription</a>
                </li>
                @endguest
                @auth
                <li class="nav-item dropdown " style=" margin-left:30rem;">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img
                      src="{{ asset('image/user.png')}}"
                      class="rounded-circle"
                      height="40"
                      alt=""
                      loading="lazy"
                    />{{Auth::user()->nom}}
                 
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">Déconnexion</a>
                  </div>
                </li>
                @endauth
              </ul>
              
           
              
      
            </div>
          </nav>        
          @yield('page-content')
          @include('layouts.footer' )
    </div>
   
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
