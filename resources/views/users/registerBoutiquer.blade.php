<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Espace de Connexion </title>
    
    <link rel="stylesheet" href="{{asset('build/assets/register.css')}}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="wrapper">
        <hr>
        <div class="title-text">
          <hr>  
            <div class="title login">Connexion</div>
          <hr>  
            <div class="title signup">Inscription</div>
            <hr>
        </div>
        <hr>
        <div class="form-container">
            @if (session()->has('success'))
              <div class="alert alert-success" style="color:green">
                {{session()->get('success')}}
              </div>
           @endif

           @if (session()->has('error'))
              <div class="alert alert-danger" >
                {{session()->get('error')}}
              </div>
           @endif

            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Se Connecter</label>
                <label for="signup" class="slide signup">S'insrire</label>
                <div class="slider-tab"></div>
            </div>
            
            <div class="form-inner">
                <form action="{{ route('handleLogin') }}" class="login" method="POST">
                   @csrf
                   @method('post')
                    <div class="field">
                        <input type="text" name="email" placeholder="adresse email" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="mot de passe" required>
                    </div>
                    <div class="pass-link"><a href="#">mot de passe oublier?</a></div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Connexion">
                    </div>
                    <div class="mt-5" style="margin-top: 10px; text-align: center;"><b style=" margin-top:10px;"> Se connecter en ten que Client? </b> <a href="{{ route('registration') }}" style="text-decoration: none;"><b>Connexion</b></a></div>
                    {{-- <img  style="position: absolute; margin-top: -15px; margin-left: -35px;" width="400px;" height="200px;" src="{{ asset('image/quin.png')}}"> --}}
                </form>
                
                <form action="{{ route('login') }}" class="signup" method="POST">
                    @csrf
                    @method('post')
                    <div class="field">
                        <input type="text" name="nom" placeholder="Entrer le nom de l'entreprise" required>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Entrer votre email" required>
                    </div>
                    <div class="field">
                        <input type="number" min="9" name="telephone" placeholder="Entrer votre numéro de Téléphone" required>
                    </div>
                    <div class="field">
                        <input type="text"  name="adresse" placeholder="Entrer votre Adresse" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="S'inscrire">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const loginText = document.querySelector(".title-text .login");
        const loginForm = document.querySelector("form.login");
        const loginBtn = document.querySelector("label.login");
        const signupBtn = document.querySelector("label.signup");
        const signupLink = document.querySelector("form .signup-link a");
        signupBtn.onclick = (() => {
            loginForm.style.marginLeft = "-50%";
            loginText.style.marginLeft = "-50%";
        });
        loginBtn.onclick = (() => {
            loginForm.style.marginLeft = "0%";
            loginText.style.marginLeft = "0%";
        });
        signupLink.onclick = (() => {
            signupBtn.click();
            return false;
        });
    </script>

</body>

</html>