

@extends('./../layouts/app')


@section('page-content')


   <div class="home-content ">

      <div class="overview-boxes">
      
          <div class="box">
            @foreach ($stocks as $stock)
            <form action="{{route('mettreAjourStock',$stock->id)}}" method="POST">
              <h2 class="text-success">Mettre à jour la quantité de {{ $stock->nom }}</h2>
              <hr>
             @csrf
             @method('post')
             
             <label for="nom_medoc">Quantité</label>
               <input type="number" name="quantite" value="{{ $stock->quantite }}">
               <label for="nom_medoc">QuantitéMinimum</label>
               <input type="number" name="quantiteMinim" value="{{ $stock->quantiteMin }}">
              
               <button type="submit" class="btn btn-success mt-1">Mettre à jour</button>
 
             </form>
             
              @break
            @endforeach
            
          </div>
     
      <!-- tables -->  

    
  </div>    
  </body>
  @endsection
</html>