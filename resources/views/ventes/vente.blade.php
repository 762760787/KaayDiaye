

@extends('../layouts/appGeran')


@section('page-content')


   <div class="home-content ">

        @if (session()->has('error'))
        <div class="alert alert-danger">
          {{session()->get('error')}}
        </div>
      @endif
      
      <div class="overview-boxes">
          <div class="box">
            @foreach ($produits as $produit)
            <form action="{{route('stockupdate',$produit->id)}}" method="POST">
              <h2 class="text-success">Vendre le {{ $produit->nom }}</h2>
              <hr>
             @csrf
             @method('post')
             
             <label for="nom_medoc">Quantité</label>
               <input type="number" min="1" name="quantiteStock" placeholder="saisir la quantité a vendre">
               <button type="submit" class="btn btn-success mt-1">Vendre</button>
 
             </form>
             
              @break
            @endforeach
            
          </div>
     
      <!-- tables -->  

    
  </div>    
  </body>
  @endsection
</html>