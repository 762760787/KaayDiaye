<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Produit;
use App\Http\Requests\StoreBoutiqueRequest;
use App\Http\Requests\UpdateBoutiqueRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function indexBoutiquer()
    {
        $produits = DB::select('select * from produits p,categories c,stocks s where p.id_cat=c.id and s.id_prod=p.id and p.statut=1 and p.user_id=?',[Auth::user()->id]);
       $boutiques = Boutique::all();
       return view('indexBoutiquer',compact('produits','boutiques' ));
    }

    public function index(Request $request, $id)
    {
        if(Auth::user()->statut =='1'){
            $boutique= DB::select('select id from boutiques where user_id = ?', [Auth::user()->id]);
            
            session(['id_boutique'=>$boutique[0]->id]);
            if($request->session()->has('id_boutique')){
                $boutique =  session('id_boutique');  
               // dd($boutique);
                $prod =  DB::select('select * from orders,produits,commandes where 
                orders.id_prod=produits.id and commandes.id_boutique=?',[$boutique]);   
                // dd($prod);
                $produits =  DB::select('select * from orders,produits,commandes where 
                orders.id_prod=produits.id  and orders.id_commande=commandes.id  and id_boutique=?',[$boutique]);    
                //dd($produits);
                $commandes = DB::select('select * from commandes,users where commandes.user_id=users.id  and commandes.id_boutique=?',[$boutique]);
                //dd($commandes);
                $ventes =  DB::select('select * from vendres,produits where vendres.id_prod=produits.id and vendres.user_id=?',[Auth::user()->id]);   

            
                return view('adminGerant',[
                    'request'=>$request,
                    'commandes'=>$commandes,
                    'prod'=>$prod,
                    'produits'=>$produits,
                    'ventes'=>$ventes,
                ]);
             }
        }else{
            return back();
        }
    }
    

      //====================================// Accueil Client
      public function accueil()
      {
          $boutiques = Boutique::all();
          return view('Clients.indexClient',compact('boutiques'));
      }
    /**
     * Cette fonction returne la vue indexClient qui affiche la liste des Produits 
     * d'un boutique selectionne.
     */
    public function indexClient(Request $request,$id)
    {
        session(['id_boutique'=>$id]);
        $boutique = DB:: SELECT("
                                SELECT nom
                                FROM boutiques 
                                WHERE id =?",[$id]);
                                //dd($boutique);
        $produits = DB::SELECT("SELECT p.id, p.nom as nomprod, p.id_cat,p.image, p.prix_unitaire, p.libelle, 
                                      s.quantiteStock, s.quantiteMinim, s.id_prod, s.id_boutique, b.nom
                                      FROM produits p, stocks s, boutiques b
                                      WHERE s.id_prod = p.id 
                                      AND s.id_boutique = b.id
                                      AND s.id_boutique = ?",[$id]);
        //dd($produits);
        //dd($boutique[0]->nom);
        return view('Clients.indexClientInterne',compact('produits','boutique'));
    }
    
    //========================= Cette fonction nous permet de retourner a la page d'accueil du client conecter
    public function retoureAccuei(Request $request)
    {
        if($request->session()->has('id_boutique')){
            $boutiques =  session('id_boutique'); 
            //dd($boutique);
            $boutique = DB:: SELECT("
                                SELECT nom
                                FROM boutiques 
                                WHERE id =?",[$boutiques]);
                                //dd($boutique);
            $produits = DB::SELECT("SELECT p.id, p.nom as nomprod, p.id_cat,p.image, p.prix_unitaire, p.libelle, 
                                        s.quantiteStock, s.quantiteMinim, s.id_prod, s.id_boutique, b.nom
                                        FROM produits p, stocks s, boutiques b
                                        WHERE s.id_prod = p.id 
                                        AND s.id_boutique = b.id
                                        AND s.id_boutique = ?",[$boutiques]);
            //dd($produits);
            return view('Clients.indexClientInterne',compact('produits','boutique'));
    
        }
    }

     //========================= Cette fonction nous permet de lister les produits de la boutique dans le menu <<Produits>>
     public function ListingProduit(Request $request)
     {
         if($request->session()->has('id_boutique')){
             $boutique =  session('id_boutique'); 
            
             $produits = DB::SELECT("SELECT p.id, p.nom as nomprod, p.id_cat,p.image, p.prix_unitaire, p.libelle, 
                                         s.quantiteStock, s.quantiteMinim, s.id_prod, s.id_boutique, b.nom
                                         FROM produits p, stocks s, boutiques b
                                         WHERE s.id_prod = p.id 
                                         AND s.id_boutique = b.id
                                         AND s.id_boutique = ?",[$boutique]);
             //dd($produits[0]->nom);
             return view('Clients.listingProduits',compact('produits'));
     
         }
     }

    //================================= Cette fonction retourne les deatail d'un produit dans le cas ou le client est connecter
    public function detailleProduitClient(Produit $produit)
    {
        //dd($produit->id);
        $produits = DB::select("SELECT * 
                                    FROM produits p
                                    INNER JOIN stocks s on(s.id_prod = p.id)
                                    AND s.id_prod =?",[$produit->id]);
        //dd($produits);
        return view('Clients.detailleProduitsClient',compact('produits'));
    }

    //========================== fonction pour afficher la liste et le nombres de produit de chaque categorie===========================
    public function listeCategorie(Request $request) {
        if($request->session()->has('id_boutique')){
            $boutique =  session('id_boutique');
            $categorie = DB::select('SELECT c.nomCat,c.id, COUNT(p.id) AS nombre_de_produits
                FROM Categories c
                LEFT JOIN Produits p ON c.id = p.id_cat
                LEFT JOIN Stocks s ON s.id_prod = p.id
                LEFT JOIN boutiques b ON s.id_boutique = b.id 
                WHERE s.id_boutique=?
                GROUP BY c.nomCat,c.id;
                ',[$boutique]);
                //dd($categorie);
               
                return view('categories.listeCategorie',compact('categorie'));
        }        
    }
//===========================fonction qui affiche les produits de chaque categorie==================================//
    public function produitDeChaqueCategorie($id) {
      
        $produits = DB::select('SELECT * from produits 
                                LEFT JOIN Stocks ON stocks.id_prod = produits.id
                                where produits.id_cat=?',[$id]);
        //dd($produits);    
        return view('categories.produitDeChaqueCategorie',compact('produits'));
      
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoutiqueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Boutique $boutique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoutiqueRequest $request, Boutique $boutique)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boutique $boutique)
    {
        //
    }
}