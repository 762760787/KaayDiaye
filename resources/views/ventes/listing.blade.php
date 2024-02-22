@extends('./../layouts/appGeran')


@section('page-content')


   <div class="home-content ">

    @if (session()->has('success'))
    <div class="alert alert-success">
      {{session()->get('success')}}
    </div>
    @endif
    <div class="overview-boxes">
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
         {{-- @if(Auth::user()->id===$medicament->user_id)  --}}
      <tr>
      
          <td>{{$produit->nom}}</td>
          <td>{{$produit->quantiteStock}}</td>
          <td>{{$produit->prix_unitaire}}</td>
          <td>{{$produit->nomCat}}</td>
          <td> 
            @if ($produit->quantiteStock === 0)
            
              <a role="link" aria-disabled="true" class="disabled btn btn-outline-danger mt-1" disabled='disabled'>vendre</a>
            @else
              <a  href="{{ route('vendreProduits',$produit->id) }}"  type="button" class="btn btn-outline-success mt-1" >vendre</a>

            @endif
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
</html>



  @endsection
