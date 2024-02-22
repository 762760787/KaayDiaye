
@extends('./layouts/appGeran')


@section('page-content')

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    
      <div class="home-content">
        <div class="overview-boxes">
          <div class="box">
            <div class="right-side">
              @php
                $user = DB::table('vendres')->where('user_id',Auth::user()->id)->count();

              @endphp
              <div class="box-topic">Produits</div>
              <div class="number">0</div>
              <div class="indicator">
                <i class="bx bx-down-arrow-alt down"></i>
                <span class="text">En stocks</span>
              </div>
            </div>
            <i class="bx bxs-cart-add cart two"></i>
          </div>
          <div class="box">
            <div class="right-side">
           
              <div class="box-topic">Profit</div>
              @php $total = 0 ; $total2=0;@endphp
              @if($request->session()->has('id_boutique'))
              @php $boutique = session('id_boutique'); @endphp
             
              @foreach($ventes as $vente)
                 
                @php $total += $vente->quantiteVendue * $vente->prix_unitaire @endphp
              
                @endforeach

              <div class="number">{{$total}} F</div>             
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Depuis hier</span>
              </div>
            </div>
            <i class="bx bx-cart cart three"></i>
          </div>
           
          @endif
          <div class="box">
            @if($request->session()->has('id_boutique'))
				     @php $pharma =  session('id_boutique');  
              $c=DB::table('commandes')->where('id_boutique',$boutique)->count();
         
              @endphp
            
            <div class="right-side">
              <div class="box-topic">Commande</div>
              <div class="number">{{ $c }}</div>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Depuis hier</span>
              </div>
            </div>
            <i class="bx bx-cart-alt cart"></i>
          </div> 
          @endif
          <div class="box">
            <div class="right-side">
              @if($request->session()->has('id_boutique'))
               @php $boutique =  session('id_boutique');  
                //$bb  = DB::select("select * from users where role ='vendeur' and id_pharma=?",[$pharma]);
                //print_r($bb[0]->role);exit();
                //$user = DB::table('users')->where('role',$bb[0]->role)
               // ->where('id_pharma',$pharma)->count();
              @endphp
              <div class="box-topic">Utilisateur</div>
              <div class="number">0</div>
              <div class="indicator">
                <i class="bx bx-down-arrow-alt down"></i>
                <span class="text">Enregistrer</span>
              </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor" class="w-6 h-6 ms-5  text-success" style="width:60px ;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
            
          </div>
        </div>
        @endif
        @php
         $prod =  DB::select('select * from orders,produits,commandes where orders.id_prod=produits.id and commandes.id_boutique=?',[$boutique]);   
         $produits =  DB::select('select * from orders,produits,commandes where orders.id_prod=produits.id  and orders.id_commande=commandes.id  and commandes.id_boutique=?',[$boutique]);    

        @endphp
          <div class="sales-boxes" style="width:120rem;">
            <div class="recent-sales box">
              <div class="title">Commandes recentes</div>
              <div class="sales-details">
               
                <ul class="details">
                  <li class="topic">Date</li>
                  {{-- @foreach ($commande as $com )
                  
                  <li><a href="#">{{ $com->dateCommande }}</a></li>
                  @endforeach --}}
                </ul>        
                <ul class="details">
                  <li class="topic">Client</li>
                  {{-- @foreach ($commande as $com )
                  <li><a href="#">{{ $com->prenom }}</a></li>
                  @endforeach --}}
                </ul>
                
               
                <ul class="details">
                  <li class="topic">Produits</li>
                  @foreach ($prod as $p)
                  <li><a href="#">{{ $p->nom }}</a></li>
                  @endforeach
                </ul>
                <ul class="details">
                  <li class="topic">Prix Produit</li>
                  @foreach ($produits as $prod)
                  <li><a href="#"></a>{{ $prod->prix_unitaire }}</li>
                  @endforeach
                 
                </ul>
              </div>
              <div class="button" >
                <a href="#" type="button" class="btn-success" >Voir Tout</a>
              </div>
            </div>
            
        </div>
 

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
  </body>
</html>



  @endsection
