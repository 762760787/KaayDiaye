
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Login & Signup Form </title>
    
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
              <div class="alert alert-success">
                {{session()->get('success')}}
              </div>
           @endif

           @if (session()->has('error'))
              <div class="alert alert-danger">
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
                    
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Connexion">
                    </div>
                    <center>
                        <div class="pass-link mt-2" style="margin-top: 10px;"><b> Se Connecter En ten que Boutiquer !</b><a href="{{route('login')}}"><b>Connexion!</b></a></div>
                        </center>
                  
                </form>
                
                <form action="{{ route('registration') }}" class="signup" method="POST">
                    @csrf
                    @method('post')
                    <div class="field">
                        <input type="text" name="nom" placeholder="Entrer votre nom complet" required>
                    </div>
                    <div class="field">
                        <input type="email" name="email" placeholder="Entrer votre email" required>
                    </div>
                    <div class="field">
                        <input type="number" min="9" name="telephone" placeholder="Entrer votre Téléphone" required>
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