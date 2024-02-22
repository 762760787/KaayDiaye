@extends('../layouts/enteteVisiteur')

@section('page-content')
    
@include('partials.search')
    <div class="container px-4 py-5" id="hanging-icons">
        <h2 class="pb-2 border-bottom">Listes des Boutiques de la plateforme</h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            @foreach ($boutiques as $boutique)
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-primary">
                        <div class="card-header py-3 text-white bg-primary border-primary">
                            <center><h4 class="my-0 fw-normal">{{ $boutique->nom }}</h4></center>
                        </div>
                        <div class="card-body"> 
                            <center>
                                <ul class="list-unstyled mt-2 mb-2">  
                                    <a  href="#" id="navbarDropdownMenuLink" aria-expanded="false">
                                        <img
                                          src="/image/{{ $boutique->image}}"
                                          class="rounded-circle"
                                          height="90"
                                          alt="logo"
                                          loading="lazy"
                                        />
                                     
                                      </a>
                                </ul>
                            </center>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li><b>Adresse : </b> {{ $boutique->adresse }}</li>
                                <li><b>Email : </b> {{ $boutique->email }}.</li>
                                <li> <b>Contact : </b> {{ $boutique->telephone }}.</li>
                                
                            </ul>
                            <a href="{{ route('indexVisiteurInterne',$boutique->id) }}" type="button" class="btn btn-lg btn-primary"> Lister les produits de cette Boutique</a>
                        </div>
                    </div>
                </div>

            @endforeach
               
            
        </div>
    </div>
@endsection
