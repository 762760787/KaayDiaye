@extends('../layouts/entete')

@section('page-content')
    

@include('partials.search');
<img src="{{ asset('image/img.jpg')}}" class="img-fluid" alt="..." style="height: 320px; width: 100%; padding: 10px 10px;">

<hr>
<div class="row">
    @forelse($produits as $produit)
    <div class="col-md-3 mt-1">
       
        <div class="card">
            <img src="image/{{ $produit->image }}" style="height: 300px;"  class="card-img-top " alt="vous">

         
            <div class="card-body">
                <div class="card-title" >{{$produit->nom}}</div>
                {{-- <div class="card-text" style="color: orange; font-family: popper;"><hr>Produits de sen Quincallerie</div> --}}
                <p
                    {{  $quantite = $produit->quantite ===0 ?'Indisponible':'Disponible' }} 
                    
                    @if($produit->quantite === 0 )
                        <span class="alert alert-danger p-1 mb-3 ms-0 w-1">Indisponible</span>
                    @else
                        <span class="alert alert-success p-1 mb-3 ms-1 w-1">En stock</span>
                    
                     @endif
  
                </p>
                <a href="{{ route('detailleProduit',$produit->id) }}" class="btn btn-info mt-1">Détails</a>
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
                {{$produits->links()}}
            </li>
        </ul>
    </div>
</div>
@endsection