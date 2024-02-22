
@extends('./../layouts/app')


@section('page-content')

<div class="home-content ">
	<div class="box">
		<div class="container">
	@if (session()->has('success'))
		<div class="alert alert-success">
		{{session()->get('success')}}
		</div>
 	@endif

	{{-- @if ($c>0) --}}
		<h2 class="text-success">Details de votre commande</h2>
		<div class="table-responsive  mb-3">
			<table class="table table-bordered table-hover bg-white mb-0">
				<thead class="thead-dark" >
					<tr>
						<th style="widht:45px; height:45px;">&#x1F6CD;</th>
						<th>Médicament</th>
						<th>Prix</th>
						<th>Quantité</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
			
					@php $total = 0 @endphp
				
					@foreach ($detailsCom as $detailsCom)
					
					@php $total += $detailsCom->prix_unitaire * $detailsCom->quantiteCom @endphp
					
						<td><img src="/image/{{ $detailsCom->image }}" class="card-img-top hover-zoom" alt="vous" style="width:50px;"></td>
						<td>{{ $detailsCom->nom }}</td>
						<td>{{ $detailsCom->prix_unitaire }}</td>
						<td> {{ $detailsCom->quantiteCom }}  </td>
					<td>
						
						<!-- Le total du produit = prix * quantité -->
						{{ $detailsCom->prix_unitaire * $detailsCom->quantiteCom}} FCFA
					</td>
					
					</tr>
				
				@endforeach
				
				</tbody>

			

			</table>
		</div>

	</div>
</div>
</div>

@endsection