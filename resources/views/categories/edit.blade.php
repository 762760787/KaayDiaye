

@extends('../layouts/appGeran')


@section('page-content')


   <div class="home-content ">

        @if (session()->has('success'))
        <div class="alert alert-success">
          {{session()->get('success')}}
        </div>
      @endif
      
      <div class="overview-boxes">
          <div class="box">
            
            <form action="{{ route('updateCategorie',$categories->id) }}" method="POST">
              <h2 class="text-success">Ajouter une catégorie </h2>
              <hr>
             @csrf
             @method('post')
             
             <label for="nom_medoc">Nom</label>
               <input type="text" name="nom"  value="{{ $categories->nom }}" >
               <label for="nom_medoc">Description</label>
               <textarea name="description">{{ $categories->description }}</textarea>
               <button type="submit" class="btn btn-success mt-1">Modifier</button>
 
             </form>
             
          </div>  
          
     
     
  </div>    
  </body>
  @endsection
</html>