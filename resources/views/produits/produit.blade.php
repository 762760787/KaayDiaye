
@extends('./../layouts/appGeran')


@section('page-content')


   <div class="home-content ">
     @if (session()->has('success'))
      <div class="alert alert-success">
        {{session()->get('success')}}
      </div>
    @endif
      <div class="overview-boxes">
      
          <div class="box">
     <div style="max-width: 410px"> 
      @if (session()->has('error'))
        <div class="alert alert-danger">
          {{session()->get('error')}}
        </div>
    @endif
            <form action="{{ route('storeProduit') }}" method="POST">
             <h2 class="text-success">Ajouter un produit</h2>
             <hr>
            @csrf
            @method('post')
              <label for="nom_medoc">Nom Produit</label>
              <input type="text" name="nom" id="nom" placeholder="Nom du produit" value="{{ old('nom')}}">

              @error('nom')
            <div class="text text-danger">
              {{$message}}
            </div>
            @enderror

            <label for="nom_medoc">Image</label>
            <input type="file" name="image" id="iamge" value="{{ old('image')}}">

            @error('image')
            <div class="text text-danger">
              {{$message}}
            </div>
            @enderror
            
          
            <label for="nom_medoc">Catégorie</label>
              <select id="categorie"  name="id_cat" >
                @foreach ($categories as $categorie )
                    <option value="{{$categorie->id }}"> {{ $categorie->nomCat}} </option>     
                @endforeach
              </select>

             <label for="nom_medoc">Quantité</label>
              <input type="number" min="1" name="quantite" id="quantite" placeholder="Quantité du produit" value="{{ old('quantite')}}">

              @error('quantite')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror
              
             <label for="nom_medoc">Quantité Minimum</label>
              <input type="number" min="1" name="quantiteMinim" id="quantiteMin" placeholder="Quantité minimun de stock du produit" value="{{ old('quantiteMinim')}}">

              @error('quantiteMinim')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror

              <label for="nom_medoc">Prix unitaire</label>
              <input type="number" min="1" name="prix_unitaire" id="prix_unitaire" placeholder="prix du produit" value="{{ old('prix_unitaire')}}">

              @error('prix_unitaire')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror
              
              

               <label for="nom_prod">Libellé</label>
              <textarea name="libelle" id="libelle" placeholder="libelle du produit">{{ old('libelle')}}</textarea>

              @error('libelle')
                <div class="text text-danger">
                {{$message}}
                </div>
              @enderror

              <button type="submit" class="btn btn-success mt-1">Ajouter et publié le Produit</button>

            </form>
          </div>
          </div>
     
      <!-- tables -->  

        <div class="box">
          <table class="mtable" border="1">
            <tr>
              <th>Nom</th>
              <th>Quantité</th>
              <th>Prix_Unitaire</th>
              <th>Catégorie</th>
              {{-- <th>DLC</th> --}}
              <th>Action</th>

            </tr>
             @forelse($produits as $produit) 
               {{-- @if(Auth::user()->id===$produit->user_id)  --}}
            <tr>
            
                <td>{{$produit->nom}}</td>
                <td>{{$produit->quantiteStock}}</td>
                <td>{{$produit->prix_unitaire}} FCFA</td>
                <td>{{$produit->nomCat}}</td>

         
                <td> 
                <form action="{{ route('produit.delete',$produit->id) }}" method="POST">
                  @csrf
                  @method('delete')
                  <a href="{{ route('editProduit',$produit->id) }}" type="submit" class="btn btn-success mt-1">Editer</a>

                 <button type="submit" class="btn btn-danger mt-1">Supprimer</button>
                </form>
               </td>
            </tr>
                {{-- @else 
              @endif --}}
      
            @empty

        @endforelse

        </table>
        </div>
  </div>    
  </body>
  @endsection
</html>