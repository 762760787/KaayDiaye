@extends('./../layouts/app')
@section('page-content')

<body>  
    <div class="home-content ">
        <div class="box">
            <div class="container">
        @if ($listeCommande)
            <h2 class="text-success">Listes des  commandes</h2>
            <hr>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session()->get('success')}}
                </div>
            @endif
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Date</th>
                    <th>Livraison</th>
                    <th>Statut</th>
                    <th>......</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($listeCommande as $comm)
                    <tr>
                        <td>{{ $comm->id }}</td>
                        <td>{{ $comm->prenom }} {{ $comm->name }}</td>
                        <td>{{ $comm->telephone  }}</td>
                        <td>{{ $comm->dateCommande  }}</td>
                        <td>{{ $comm->typeLivraison }}</td>
                        @if($comm->statut == 1 )
                        <td>validée</td>
                        @elseif ($comm->statut == 2)
                        <td class="text-success">livrée</td>
                        @endif
                        <td>
                        @if ($comm->statut == 1)
                        <a  href="{{ route('statutCommandes',$comm->id) }}" class="btn btn-success">Livrer</a>
                        @endif
                        <a  href="{{ route('DetailsCommandesGerant',$comm->id) }}" class="btn btn-info">Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
          <div class="alert alert-info">Aucune commande passée pour le moment</div>
     
      @endif
            </div>
        </div>
    </div>
</div>
</body>
@endsection