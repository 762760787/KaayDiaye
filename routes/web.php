<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\BoutiqueController;
use App\http\Controllers\ProduitController;
use App\http\Controllers\CategorieController;
use App\http\Controllers\PanierController;
use App\http\Controllers\UserController;
use App\http\Controllers\StockController;
use App\http\Controllers\CommandeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//======************************************* Cote Client *********************************************//

//================================// Route dirigeant dans l'interface indexVisiteur//====================// 
        Route::get('/',[UserController::class, 'index']);
//==================================// Route dirigeant dans l'interface indexVisiteur quant la boutique est selectionner//
        Route::get('/indexVisiteurInterne/{id}',[UserController::class, 'indexVisiteurInterne'])->name('indexVisiteurInterne');
//==================================// Route pour afficher les detailles d'un produits en tenque Client=======================//
        Route::get('/detailProduitsVisteur/{produit}',[ProduitController::class,'detaille'])->name('detailProduitsVisteur');


    
//==========================middelware regroupant les route qui non pas besoing de Auth..==========// 
Route::middleware(['guest'])->group(function(){    
    //========================================enregistre un utilisateur client===============================//     
            Route::get('/register', [UserController::class, 'login'])->name('registration');
            Route::post('/register', [UserController::class, 'handleRegistration'])->name('registration');
    
    //==========================connecter un utilisateur boutiquer==========================================//
            Route::get('/login',[UserController::class, 'register'])->name('login');
            Route::post('/login',[UserController::class,'RegistrationBoutiquer'])->name('login');

            Route::post('/handleLogin',[UserController::class,'handleLogin'])->name('handleLogin');

});


  
//==========================middelware regroupant les route qui on besoins d'une Auth..==========// 
 Route::middleware(['auth'])->group(function(){

   //================================// Route dirigeant dans l'interface indexClient//====================// 
   Route::get('/accueil',[BoutiqueController::class, 'accueil'])->name('accueil')->withoutMiddleware('auth');    
   //==================================// Route redirigeant dans l'interface indexClient quant la boutique est selectionner//
   Route::get('/indexClientInterne/{id}',[BoutiqueController::class, 'indexClient'])->name('indexClientInterne')->withoutMiddleware('auth');
   
   //===================================== route de retoure a la page d'accueil
   Route::get('/retoureAccuei',[BoutiqueController::class, 'retoureAccuei'])->name('retoureAccuei')->withoutMiddleware('auth');
       //===================================== route redirigeant dans le controleur qui retourne la liste des produits
   Route::get('/ListingProduit',[BoutiqueController::class, 'ListingProduit'])->name('ListingProduit')->withoutMiddleware('auth');

   //==================================// Route pour afficher les detailles d'un produits en tenque Client=======================//
   Route::get('/detailProduitsClient/{produit}',[BoutiqueController::class,'detailleProduitClient'])->name('detailleProduitClient')->withoutMiddleware('auth');
   
   //===================================== route redirigeant dans le controleur qui retourne la liste des categorie
   Route::get('/listeCategorie',[BoutiqueController::class, 'listeCategorie'])->name('listeCategorie')->withoutMiddleware('auth');

  //===================================== route redirigeant dans le controleur qui retourne la liste des produits de chaque categorie
   Route::get('/produitDeChaqueCategorie/{id}',[BoutiqueController::class, 'produitDeChaqueCategorie'])->name('produitDeChaqueCategorie')->withoutMiddleware('auth');




        
    //==========================page accueil du boutique==========================================//
    Route::get('/indexBoutiquer',[BoutiqueController::class,'indexBoutiquer'])->name('indexBoutiquer');
        //=========================page admin du boutiquer ===================================================//
    Route::get('/adminGerant/{id}',[BoutiqueController::class, 'index'])->name('adminGerant');
    
        //===============================//Ajouter une categories//===========================================//
        Route::get('/createCategorie',[CategorieController::class,'create'])->name('createCategorie');
        Route::post('/storeCategorie',[CategorieController::class,'store'])->name('storeCategorie');
        //==============================// Modifier et supprimer une categorie================================//
        Route::get('/editCategorie/{categories}',[CategorieController::class,'edit'])->name('editCategorie');
        Route::post('/updateCategorie/{categories}',[CategorieController::class,'update'])->name('updateCategorie');
        
        //============================// Route pour la gestion des produits //========================================//
        Route::get('/createProduits',[ProduitController::class,'create'])->name('AjouterProduit');
        Route::post('/storeProduits',[ProduitController::class,'store'])->name('storeProduit');
        Route::post('/stockupdate/{id}',[ProduitController::class,'stockupdate'])->name('stockupdate');
        Route::get('/detailProduits/{produit}',[ProduitController::class,'show'])->name('detailProduit');
        Route::post('/updateProduits/{id}',[ProduitController::class,'update'])->name('updateProduit');
        Route::get('/editeditProduit/{id}',[ProduitController::class,'edit'])->name('editProduit');
        
        //=================================// gere les ventes //===========================================//
        Route::get('/listProdGerant',[ProduitController::class,'listProdGerant'])->name('listProdGerant');
        Route::get('/vendreProduits/{id}',[ProduitController::class,'vendreProduits'])->name('vendreProduits');
        Route::post('/stockupdate/{id}',[ProduitController::class,'stockupdate'])->name('stockupdate');
        Route::delete('/deleteProduits',[ProduitController::class,'destroy'])->name('produit.delete');
       
        //===============================================// Gere le stock //===================================//
        Route::get('/listProduitsStock',[StockController::class,'index'])->name('listeProduitStock');
        Route::post('/updateQuantityStock',[StockController::class,'update'])->name('updateQuantityStock');


        //=====================================les Routes concernant le panier de user=============================//
        Route::post('/addPanier/{id}',[PanierController::class, 'store'])->name('addPanier');
        Route::get('/listpanier',[PanierController::class, 'index'])->name('listpanier');
        Route::post('/updatePanier/{id}',[PanierController::class, 'update'])->name('updatePanier');
        Route::get('/deletePanier/{id}',[PanierController::class, 'delete'])->name('deletePanier');


        //=======================================commander produit==============================================//
        Route::get('/commande',[CommandeController::class, 'index'])->name('createcommande');
        Route::post('/DetailsFacture',[CommandeController::class,'DetailsFacture'])->name('DetailsFacture');
        Route::get('/Validecommande',[CommandeController::class, 'Validecommande'])->name('Validecommande');
        Route::get('/listerCommandes',[CommandeController::class, 'listerCommandes'])->name('listerCommandes');
        Route::get('/afficheDetails/{id}',[CommandeController::class, 'afficheDetails'])->name('afficheDetails');

        
        Route::get('/logout',[UserController::class, 'logout'])->name('logout');
        
});