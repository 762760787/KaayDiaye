
@extends('./../layouts/enteteClient')


@section('page-content')
<div class="home-containe">
  <div class="alert alert-success w-100 h-100" role="alert">
    <center><h4 class="alert-heading mt-2" style="font-size: 5rem">Merci!!!</h4>
      <hr>
    <p class="mb-1 text-dark" style="font-size: 40px;">Votre commande à été traitée avec succés </p>
    
    <p style="font-size: 30px;" class="mb-0 text-dark">Vous rencontrez un probléme ? <a href="#" class="text-success" style="text-decoration: none;"><span style="font-family: 'Times New Roman', Times, serif; ">Nous contacter</span> </a></p>
      
    <div>
        <a href="#"  class="btn btn-success mt-4 fs-3" style="font-family: 'Times New Roman', Times, serif; ">Continuer vers la boutique</a>
      </div>
  </center>
  </div>
</div>

@endsection