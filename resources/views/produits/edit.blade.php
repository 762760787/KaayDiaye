

@extends('./../layouts/app')


@section('page-content')


   <div class="home-content ">
     @if (session()->has('success'))
              <div class="alert alert-success">
                {{session()->get('success')}}
              </div>
           @endif
           
      <div class="overview-boxes">
      
          <div class="box">
            @foreach ($produits as $prod)
            <form action="{{ route('updateProduit',$prod->id) }}" method="POST">
             
             <h2 class="text-success">Modifier le {{ $prod->nom }}</h2>
             <hr>
            @csrf
            @method('post')
           
              
              <label for="nom_medoc">Nom du produit</label>
              <input type="text" name="nom" id="nom" placeholder="Nom du produit" value="{{$prod->nom}}">

              <label for="nom_medoc">Image</label>
            <input required type="file" name="image" id="iamge" values="{{ $prod->image }}">
     
            <label for="nom_medoc">Catégorie</label>
            <select id="categorie"  name="id_cat" value="{{$prod->id_cat }}" >
              <option value="{{$prod->id_cat }}"> {{ $prod->nomCat}} </option>     

              @foreach ($categories as $categorie )
                <option value="{{$categorie->id }}"> {{ $categorie->nomCat}} </option>     
             @endforeach
            </select>

              <label for="nom_medoc">Prix unitaire</label>
              <input type="number" min="1" name="prix_unitaire" value="{{$prod->prix_unitaire}}">

               <label for="nom_medoc">Libelle</label>
              <textarea name="libelle" >{{$prod->libelle}}</textarea>


              <button type="submit" class="btn btn-success mt-1">Editer</button>
             
            </form>
            @break
            @endforeach
          </div>
     
      <!-- tables -->  

    
  </div>    
  </body>
  @endsection
</html>