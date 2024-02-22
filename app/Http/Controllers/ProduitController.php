<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class ProduitController extends Controller
{
   
    public function index()
    {
        //
    }

  
    //=============================fontion pour Ajouter un produit=========================//

    public function create()
    {
        $produits = DB::select('select * from produits p,categories c,stocks s where p.id_cat=c.id and s.id_prod=p.id and p.statut=1 and p.user_id=?',[Auth::user()->id]);
       //dd($produits);
        $categories = DB::select('select * from categories where user_id=?',[Auth::user()->id]);
       return view('produits.produit',[
            'produits'=>$produits,
            'categories'=>$categories
       ]);
    }


    //================// Enregistrement instantane d'un produit dans la table produits et stock======================// 
    public function store(Produit $produits, Request $request)
    {
        //dd($request);
        if(Auth::user()->statut== 1){
            $categories = DB::select("select categories.id from categories where categories.id=?",[$request->id_cat]);
            //dd($categories[0]->id);
            if($request->nom === null || $request->image === null || $request->id_cat === null || $request->prix_unitaire === null
                ||  $request->libelle === null ||  $request->quantite === null || $request->quantiteMinim===null){
               return redirect()->Route('AjouterProduit')->with('error','Veuillez remplire toutes les champs');
            
            }else{
                if($request->session()->has('id_boutique')){
                    $boutique =  session('id_boutique');  
                    //dd($boutique);
                    $produits->nom = $request->nom;
                    $produits->image = $request->image;
                    $produits->statut = 1;
                    $produits->id_cat = $categories[0]->id;
                    $produits->prix_unitaire = $request->prix_unitaire;
                    $produits->libelle = $request->libelle;
                    $produits->user_id = Auth::user()->id;
                    $produits->save();

                    $id = $produits->id;
                    $quantite = $request->quantite;
                    $quantiteMinim = $request->quantiteMinim;
                
                    DB::insert('insert into stocks (quantiteStock,quantiteMinim,id_boutique,id_prod) value(?,?,?,?)',[$quantite,$quantiteMinim,$boutique,$id,]);
            
                    return back()->with('success','Produit ajouté avec succés');
                }
            }
        
        }else{
            return back();
        }
    }

 //=================================== Fonction affiche les deaille d'un produit en ten que visiteur //==================//
    public function detaille(Produit $produit)
    {
        //dd($produit->id);
        $produits = DB::select("SELECT * 
                                    FROM produits p
                                    INNER JOIN stocks s on(s.id_prod = p.id)
                                    AND s.id_prod =?",[$produit->id]);
        //dd($produits);
        return view('produits.detailleProduitsVisiteur',compact('produits'));
    }

//=================================== Fonction affiche les deaille d'un produit en ten que boutiquer //==================//
    public function show(Produit $produit)
    {
        //dd($produit->id);
        $produits = DB::select("SELECT * 
                                    FROM produits p
                                    INNER JOIN stocks s on(s.id_prod = p.id)
                                    AND s.id_prod =?",[$produit->id]);
        //dd($produits);
        return view('produits.detaille',compact('produits'));
    }


   //==============================================editer un produit=========================================
   public function edit($id) {
        if(Auth::user()->statut== 1){
            //dd($id);
            $produits = DB::SELECT("SELECT c.nomCat,p.id,p.id_cat,p.nom,p.image,p.prix_unitaire,p.libelle
                                    FROM categories c, produits p
                                    WHERE p.id_cat = c.id  and p.id = ?",[$id]);

            $categories = DB::select('select * from categories where user_id = ?',[Auth::user()->id]);
            return view('produits.edit',[
                'produits'=>$produits,
                'categories'=>$categories
            ]);
        }else{
            return back();
        }
    }

    public function update($id,Request $request)
    {
        if(Auth::user()->statut == 1){
            //dd($request);
            $nom = $request->nom;
            $image = $request->image;
            $id_cat = $request->id_cat;
            $prix_unitaire = $request->prix_unitaire;
            $libelle = $request->libelle;
            
            DB::update('update produits set nom = ?, image=?,id_cat =?, prix_unitaire=?,libelle=? where id = ?', [$nom,$image,$id_cat,$prix_unitaire,$libelle,$id]);
            
            return redirect()->Route('AjouterProduit')->with('success','Produit mise à jour');
        }else{
            return back();
        }
    }

//=======================fonction pour lister les produit a vendre au niveau de admin
    public function listProdGerant()
    {
        if(Auth::user()->satatut= 1){
            $produits = DB::select('select p.id,p.nom,p.prix_unitaire,s.quantiteStock,s.quantiteMinim,c.nomCat from produits p,categories c,stocks s where p.id_cat=c.id and s.id_prod=p.id and p.statut=1 and p.user_id=?',[Auth::user()->id]);

            return view('ventes.listing',compact('produits'));
        }else{
            return back();
        }
    }

//===========================fonction pour affichant le formulaire de vente niveau admin
    public function vendreProduits($id)
    {
        if(Auth::user()->statut== 1){
            $produits = DB::select('select * from produits  where id=?',[$id]);
            return view('ventes.vente',compact('produits'));
        }else{
            return back();
        }
    }

//==================fonction pour mettre a jour le stock apres vente===========================//
    public function stockupdate(Request $request,$id){
        if(Auth::user()->statut== 1){
            $quantiteVendue  = $request->quantiteStock;
        
            $app =  DB::select('select s.id,quantiteStock from produits p,stocks s where  s.id_prod=p.id and p.id=?',[$id]);
            //dd($app);
            foreach($app as $pa){
            
                if($quantiteVendue > $pa->quantiteStock){
                    return back()->with('error','la quantité saisie n\'est pas disponible');
                }else{  
                       //dd($request->quantiteStock) ;   
                    DB::update('update stocks set quantiteStock = '.$pa->quantiteStock - $request->quantiteStock.' where id = ?', [$pa->id]);
                    DB::insert('insert into vendres (user_id, id_prod, quantiteVendue) values (?, ?, ?)', [Auth::user()->id,$id,$request->quantiteStock]);
                    return redirect()->Route('listProdGerant')->with('success','Produit vendu avec succés');
                }
                break;
            }
        }else{
            return back();
        }
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        //
    }

}