@extends('./../layouts/enteteClient')
@section('page-content')

{{-- <div class="container ms-5 mb-2" style="max-width:50%;">
<hr>
<div class=" text-success mt-1 mb-1"><h3>Détails de facturation</h3></div>
    <div class="col-md-4"></div> 
        <form class="row g-3" action="{{ route('DetailsFacture') }}" method="POST">
            @csrf
            @method('post')
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nom<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nom">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Prénom<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="prenom">
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Région/Département<span class="text-danger">*</span></label>
                <select name="region" class="form-select">
                <option value="Thies">Thiès</option>
                <option value="dakar">Sait-Liou</option>
                <option value="dakar">Dakar</option>
            </select>
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Numéro et nom de rue<span class="text-danger">*</label>
                <input type="text" class="form-control" name="numero" placeholder="Numéro voi et nom de la rue">
            </div>
            <div class="col-12">
                <input type="text" class="form-control" id="inputAddress2" placeholder="Bâtiment,appartement,lot etc. (facultatif)">
            </div>
            <div class="col-md-6">
            <label for="inputAddress"  class="form-label">Type de livraison<span class="text-danger">*</span></label>
                <select name="typeLivraison" class="form-select">
                <option>En pharmacie</option>
                <option>A domicile</option>
            </select>
            </div>
            <div class="col-md-6">
                <label name="telephone" class="form-label">Téléphone<span class="text-danger">*</label>
                <input type="number" class="form-control" name="telephone">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email"  placeholder="Votre adresse email">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-success" type="submit">Commander</button>
            </div>
        </form>
    </div>
</div> --}}

{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="col-md-6 offset-md-3">
    <span class="anchor" id="formPayment"></span>
             
<!-- form card cc payment -->
        <div class="card card-outline-secondary mt-5">
            <div class="card-body">
                <h3 class="text-center">Detaille du Paiement.</h3>
                <hr>
                <div class="alert alert-info p-2 pb-3">
                    <a class="close font-weight-normal initialism" data-dismiss="alert" href="#"><samp>×</samp></a> 
                    Le champ type de livraison est requis.
                </div>
                                  
                <form class="form" action="{{ route('DetailsFacture') }}" method="POST">
                    @csrf
                    @method('post')
                        <div class="form-group">
                            <label for="cc_name">Votre nom Complet</label>
                            <input type="text" class="form-control" id="cc_name" pattern="\w+ \w+.*" title="First and last name" value="{{ Auth::user()->nom }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Votre adresse</label>
                            <input type="text" class="form-control" autocomplete="off" maxlength="20" pattern="\d{16}" title="Credit card number" value="{{ Auth::user()->adresse }}" readonly>
                        </div>
                        <div class="col-md-12">
                            <label name="telephone" class="form-label">Téléphone<span class="text-danger"></label>
                            <input type="text" class="form-control" value="{{ Auth::user()->telephone}} "readonly>
                            <label for="inputAddress"  class="form-label">Type de livraison<span class="text-danger">*</span></label>
                            <select name="typeLivraison" class="form-select">
                            <option>En Boutique</option>
                            <option>A domicile</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">Date d'expiration</label>
                            <div class="col-md-4">
                                <select class="form-control" name="cc_exp_mo" size="0">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="cc_exp_yr" size="0">
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" title="Three digits at back of your card" placeholder="CVC">
                            </div>
                        </div>
                                
                        <div class="row">
                            <label class="col-md-12">Montant total</label>
                        </div>
                        <div class="form-inline">
                        @php $total = 0 @endphp
	          
                            @foreach ($paniers as $pan)
                                    
                                @php $total += $pan->prix_unitaire * $pan->quantitePanier @endphp
                            @endforeach
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">FCFA</span></div>
                                <input type="text" class="form-control text-right" id="exampleInputAmount" value="{{ $total }}" readonly>
                                <div class="input-group-append"><span class="input-group-text">.00</span></div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-6">
                                        <button type="reset" class="btn btn-default btn-lg btn-block">Annuller</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-lg btn-block">valider la Commande</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
                    <!-- /form card cc payment -->
                
                <p class="copyright" style="text-align:center;padding:40px 0;">Developed by <a href="https://uny.ro">UNY WEB DESIGN</a></p>
@endsection