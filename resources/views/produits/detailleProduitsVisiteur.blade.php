@extends('./../layouts/enteteClient')


@section('page-content')

<hr>
<div class="row">
    @if (session()->has('error'))
        <div class="alert alert-danger">
        {{session()->get('error')}}
        </div>
    @endif
    @if (session()->has('success'))
              <div class="alert alert-success">
                {{session()->get('success')}}
              </div>
           @endif
    @foreach($produits as $produit)
        <div class="col-md-6">
            <div>
                <img src="/image/{{ $produit->image }}" style="margin-left: 2px" alt="" width="100%" height="100%">
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-warning display-3" style="font-family: popper ;">
                {{ $produit->nom }}
            </div>
            <div class="text-info" style="font-size: 30px; font-family: popper bolder;">
                Prix: {{ $produit->prix_unitaire }} FCFA
            </div>
            <div>
                {{ $produit->libelle }}
            </div>
            <p class="alert alert-success mt-2">
                {{ $produit->quantiteStock }} En stock
            </p>
            <form action="#" method="POST" class="mt-2">
                @csrf
                @method('post')
                <div class="input-field col">
                    {{-- <input type="hidden" id="id" name="id" value="{{ $medicament->id }}"> --}}
                    @if($produit->quantiteStock > 0 )
                    <label for="quantity" style="position: absolute; margin-left: 21rem; margin-top:-1px; font-family: 'Times New Roman', Times, serif; font-weight: bold;">Quantité</label>        
                    <input id="quantity" name="quantiteStock" type="number" class="form-control" value="1" min="1" style="width:20rem;">
                    <p>
                      <button class="btn btn-success mt-4" style="width:100%" type="submit" id="addcart">+Ajouter au panier</button>
                    </p> 
                    @endif   
                  </div>  
            </form>
        </div>
    @endforeach
</div>

@endsection