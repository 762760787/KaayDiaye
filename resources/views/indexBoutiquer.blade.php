@extends('../layouts/entete')

@section('page-content')
    

@include('partials.search')
@foreach ( $boutiques as $boutique )
    <center>    
        <div class="bg-light p-5 rounded mt-3">
            <h1>Bienvenu dans votre plateforme <b>KAAYE DJAAYE</b></h1>
            <p class="lead">Une plateforme Vous permetant de gerer les ventes et le stock  de vos produits, <br>
                Avec KAAYE DJAAYE Tout est possible
            </p>
            
            <a class="btn btn-lg btn-primary" href="{{route('adminGerant',$boutique->id)}}" role="button">Acceder à l' espace de Gestion de vos produits &raquo;</a>
        </div>
    </center>
    @break
@endforeach
    
<hr>
<div class="row">
    @forelse($produits as $produit)
    <div class="col-md-3 mt-1">
       
        <div class="card">
            <img src="image/{{ $produit->image }}" style="height: 300px;"  class="card-img-top " alt="vous">

         
            <div class="card-body">
                <div class="card-title" ><b>{{$produit->nom}}</b></div>
                {{-- <div class="card-text" style="color: orange; font-family: popper;"><hr>Produits de sen Quincallerie</div> --}}
                <p
                    {{-- {{  $quantite = $produit->quantiteStock ===0 ?'Indisponible':'Disponible' }}  --}}
                    
                    @if($produit->quantiteStock === 0 )
                        <span class="alert alert-danger p-1 mb-3 ms-0 w-1">Indisponible</span>
                    @else
                        <span class="alert alert-success p-1 mb-3 ms-1 w-1">{{ $produit->quantiteStock }} En stock</span>
                    
                     @endif
  
                </p>
                <a href="{{route('detailProduit',$produit->id)}}" class="btn btn-info mt-1">Détails</a>
                <a href="#" class="btn btn-success mt-1">{{$produit->prix_unitaire}} FCFA</a>
            </div>
        </div>
        
    </div>
    @endforeach
    
</div>
<div class="row mt-3">
    <div class="col-md-3 offset-md-4">
        <ul class="pagination">
            <li class="page-item">
                {{-- {{$produits->links()}} --}}
            </li>
        </ul>
    </div>
</div>
@endsection