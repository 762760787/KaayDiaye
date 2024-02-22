@extends('./../layouts/enteteClient')
@section('page-content')

    <div class="container">
    @if ($listeCommande)
    <hr>
      <h1 class="text-success">Vos commandes</h1>
      <hr>
      @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
      @endif

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nom de la Boutique</th>
            <th>Date</th>
            <th>Livraison</th>
            <th>Statut</th>
            <th>......</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($listeCommande as $comm)
            <tr>
                <td>{{ $comm->nom }}</td> 
                <td>{{ $comm->dateCommande }}</td> 
                <td>{{ $comm->typeLivraison }}</td>
                @if ($comm->statut==0)
                <td>validée</td>
                @elseif ($comm->statut==1)
                <td>Livrée</td>
                @endif
               
             
                <td>
               
                  <a  href="{{ route('afficheDetails',$comm->id) }}" class="btn btn-info">Details</a>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      @else
      <div class="alert alert-info">Aucune commande passée pour le moment</div>
     
      @endif
    </div>
  </body>
</html

@endsection