@extends('../layouts/enteteClient')

@section('page-content')
    
@include('partials.search')

<div class="row">
    @forelse($produits as $produit)
    <div class="col-md-3 mt-1">
       
        <div class="card">
            <img src="/image/{{ $produit->image }}" style="height: 300px;"  class="card-img-top " alt="vous">  
            <div class="card-body">
                <div class="card-title" >{{$produit->nomprod}}</div>
                <p
                {{  $quantite = $produit->quantiteStock ===0 ?'Indisponible':'Disponible' }} 
                
                @if($produit->quantiteStock === 0 )
                    <span class="alert alert-danger p-1 mb-3 ms-0 w-1">Indisponible</span>
                @else
                    <span class="alert alert-success p-1 mb-3 ms-1 w-1">En stock</span>
                
                 @endif

            </p>
                <a href="{{route('detailProduitsVisteur',$produit->id)}}" class="btn btn-info mt-2">Détails</a>
                <a href="#" class="btn btn-success mt-2">{{$produit->prix_unitaire}} FCFA</a>
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



    {{-- <div class="container px-4 py-5" id="hanging-icons">
        <h2 class="pb-2 border-bottom">Listes des Boutiques de la plateforme</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            @foreach ($boutiques as $boutique)
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-primary">
                        <div class="card-header py-3 text-white bg-primary border-primary">
                            <h4 class="my-0 fw-normal">{{ $boutique->nom }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                                <img src="image/{{ $boutique->image  }}" alt="logo" class="bi" width="1em" height="1em"><use xlink:href="#toggles2"/></svg>
                            </div>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li><b>Adresse : </b> {{ $boutique->adresse }}</li>
                                <li><b>Email : </b> {{ $boutique->email }}.</li>
                                <li> <b>Contact : </b> {{ $boutique->telephone }}.</li>
                                
                            </ul>
                            <button type="button" class="btn btn-lg btn-primary"> Lister les produits de cette Boutique</button>
                        </div>
                    </div>
                </div>

            @endforeach
               
            
        </div>
    </div> --}}
@endsection
