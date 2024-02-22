
@extends('./../layouts/enteteClient')


@section('page-content')

<div class="container">

	@if (session()->has('success'))
		<div class="alert alert-success">
		{{session()->get('success')}}
		</div>
 	@endif

	 @if (session()->has('error'))
		<div class="alert alert-danger">
		{{session()->get('error')}}
		</div>
  	@endif

	@if ($paniers)
	
	<h1 class="text-success">Mon panier</h1>
	<div class="table-responsive  mb-3">
		<table class="table table-bordered table-hover bg-white mb-0">
			<thead class="thead-dark" >
				<tr>
					<th style="widht:45px; height:45px;">&#x1F6CD;</th>
					<th>Produits</th>
					<th>Prix</th>
					<th>Quantité</th>
					<th>Total</th>
					<th>Opérations</th>
				</tr>
			</thead>
			<tbody>
		
				@php $total = 0 @endphp
	          
                @foreach ($paniers as $pan)
				
					@php $total += $pan->prix_unitaire * $pan->quantitePanier @endphp
                
						<td><img src="/image/{{ $pan->image }}" class="card-img-top hover-zoom" alt="vous" style="width:50px;"></td>
						<td>{{ $pan->nom }}</td>
						<td>{{ $pan->prix_unitaire }}</td>
						<td>  
							<form  action="{{ route('updatePanier',$pan->idApp) }}" method="POST" class="form-inline d-inline-block" >
								@csrf
								@method('post')
								<div style="position: relative">
									<select name="quantitePanier" id="" class="form-control mr-2 me-4  " style="width: 80px">
										<option selected="selected">{{ $pan->quantitePanier }}</option>
										@for ($i = 1 ; $i <= ($pan->quantiteStock) ; $i++)
											<option value="{{ $i }}"> {{ $i }} </option>
										@endfor
									</select>
									{{-- <input type="number" name="quantite" placeholder="Quantité ?" value="{{ $pan->quantites}}" class="form-control mr-2 me-4" style="width: 80px" > --}}
									<input type="submit" class="btn btn-outline-info float-lg-start " value="Actualiser" style="position:absolute; margin-left:94px; margin-top:-38px; width:100px;" />
								</div>
							
							</form>
                		</td>
						<td>
			
							<!-- Le total du produit = prix * quantité -->
							{{ $pan->prix_unitaire * $pan->quantitePanier}} FCFA
						</td>
						<td>
							<!-- Le Lien pour retirer un produit du panier -->
							<a href="{{ route('deletePanier',$pan->idApp) }}" type="submit" class="btn btn-outline-danger" title="Retirer le produit du panier" >Retirer le produit</a>
						
						</td>
					</tr>
			
			  @endforeach
			<tr colspan="2" >
			<td colspan="4" >Total général</td>
			<td colspan="2">
					
					<!-- On affiche total général -->
					<strong>{{$total }} FCFA</strong>
				</td>
			</tr>
			
		</tbody>
		</table>
		@else
			<div class="alert alert-info">Aucun produits dans le panier</div>
		   
		@endif
	

</div>
	<!-- Lien pour vider le panier -->
	{{-- <a class="btn btn-outline-danger mb-4 fs-5" href="{{ route('basket.empty') }}" title="Retirer tous les produits du panier" >Vider le panier</a> --}}

<a class="btn btn-success  mb-3 ms-1 mt-1 fs-5" href="{{ route('retoureAccuei') }}" title="Retourner pour conntinuer l'achat" >Continuer vos achats</a>

<a class="btn btn-success mb-3 fs-5 mt-1"  style="margin-left:920px "  href="{{ route('createcommande') }}" title="commander" >Commander</a>


</div>
</div>


@endsection