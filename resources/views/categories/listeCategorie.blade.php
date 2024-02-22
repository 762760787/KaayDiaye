@extends('../layouts/enteteClient')

@section('page-content')

<div class="container">
  <hr>
  <center><h2>Liste des Catégories</h2></center>
  <hr>
    <ol class="list-group list-group-numbered mt-3 mb-5" style="width: 50%; margin-left: 25%;">
      @foreach($categorie as $categorie)
        
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
              <div class="fw-bold"> <a style="text-decoration: none; text-transform: uppercase" href="{{ route('produitDeChaqueCategorie',$categorie->id) }}">{{ $categorie->nomCat }}</a> </div>
             *******************************************
            </div>

            <span class="badge bg-primary rounded-pill">{{ $categorie->nombre_de_produits }}</span>
          </li>
      @endforeach     
    </ol>
  
  </div> 

@endsection