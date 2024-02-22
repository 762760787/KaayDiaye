

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
            
            <form action="{{ route('storeCategorie') }}" method="POST">
              <h2 class="text-success">Ajouter une catégorie </h2>
              <hr>
             @csrf
             @method('post')
             
               <label for="nom_medoc">Nom</label>
               <input type="text"  name="nomCat"  placeholder="saisir le nom de la catégorie">
               @error('nom')
                  <div class="alert alert-danger">
                    {{$message}}
                  </div>
                @enderror
               <label for="nom_medoc">Description de la catégorie</label>
               <input type="text"  name="description"  placeholder="Donner une Description à la catégorie">
               @error('description')
                  <div class="alert alert-danger">
                    {{$message}}
                  </div>
               @enderror
               <button type="submit" class="btn btn-success mt-1">Ajouter</button>
 
             </form>
             
          </div>  
          
     
      <!-- tables -->  
      <div class="box">
        <table class="mtable" border="1">
          <tr>
            <th>Numero</th>
            <th>Nom de la catégorie</th>
              {{-- <th>DLC</th> --}}
            <th>Action</th>

          </tr>
           @forelse($categories as $categorie) 
             {{-- @if(Auth::user()->id===$medicament->user_id)  --}}
          <tr>
          
              <td>{{ $categorie->id }}</td>
              <td>{{ $categorie->nomCat }}</td>
    
              <td> 
              <form action="#" method="POST">
                @csrf
                @method('post')
                <a href="{{ route('editCategorie',$categorie->id) }}" type="submit" class="btn btn-success mt-1">Editer</a>

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