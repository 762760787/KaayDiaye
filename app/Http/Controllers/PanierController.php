<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Http\Requests\StorePanierRequest;
use App\Http\Requests\UpdatePanierRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class PanierController extends Controller
{
    //================================fontion pour lister le panier=================================/
    public function index(Request $request)
    {
        if(Auth::user()->role== NULL){
            if($request->session()->has('id_boutique')){
                $boutique =  session('id_boutique'); 
                $user = Auth::user()->id;
                $panier = DB::select('select id from paniers  where user_id=?',[$user]);
                //=========================== Pour afficher les produits dans le panier
                $paniers = DB::SELECT("SELECT a.idApp, p.nom,p.prix_unitaire,p.image,a.quantitePanier,s.quantiteStock 
                                   FROM appartenirs a
                                   LEFT JOIN paniers pa ON(a.id_panier = pa.id)
                                   LEFT JOIN produits p ON (a.id_prod = p.id)
                                   LEFT JOIN stocks s ON(s.id_prod = p.id)
                                   LEFT JOIN boutiques b ON(s.id_boutique = b.id)
                                  
                                   WHERE pa.id=? AND b.id=?",[$panier[0]->id,$boutique]
                                   );
                                   //dd($paniers);
                return view('paniers.listpan',compact('paniers'));
            }
        }else{
            return back();
        }
    }

//=====================================fomtion pour ajouter au panier===========================================================================//
    public function store(Request $request,$id)
    {
        if(Auth::user()->role== NULL){
            //====================ICI on selectionne la quantite du produit en stocks qui est selectionner
            $produits = DB::select('select quantiteStock from stocks as s
            LEFT JOIN produits as p ON(s.id_prod = p.id) 
            WHERE p.id= ?', [$request->id]);
           //dd($produits[0]->quantiteStock);
           //=========== On recupere l'id de l'utilisateur connecter
            $user = Auth::user()->id;
            //=============== on recupere l'id panier de l'utilisateur connecter
            $panier = DB::select('select p.id from paniers p,users u where p.user_id=u.id and u.id=?',[$user]);
            //==================== on selection le produite qui est selectioner
            $produit = DB::select('select * from stocks s, produits p where s.id_prod = p.id and p.id = ?', [$request->id]);
            //dd($produit);
            //========================= ICI on recupere l'id produits qui est dans la table appartenir
            $app = DB::select('select id_prod from appartenirs a,produits p,paniers pa where a.id_prod=p.id and a.id_panier=pa.id and p.id=? and pa.id=?',[$request->id,$panier[0]->id]);
            // ====== ICi on fait un teste si cette pour verifier si la quantite demander est superieur a la quantite en stock 
            //dd($request->quantiteStock);
            if($produits[0]->quantiteStock < $request->quantiteStock ){
                return back()->with('error',"La quantité demandée n'est pas disponible");
            //======================= Ici on teste si le produit existe au pannieer ===========
            }elseif(!empty($app)){
                return Redirect()->Route("listpanier")->with('error',"La produit existe au panier");
            }else{
                DB::insert('insert into appartenirs (id_panier,id_prod,	quantitePanier) values (?, ?, ?)', [$panier[0]->id,$request->id,$request->quantiteStock]);
                return back()->with('success',"La produit ajouter au panier");
            }
        }else{
            return back();
        }
    }

    
    
    
    //==========================fonction pour metre a jour la quantie au niveau du panier=======================//
    public function update(Request $request, $id)
    {
        if(Auth::user()->role== Null){
            //dd($id);
            DB::update('update appartenirs set quantitePanier = ? where idApp = ?', [$request->quantitePanier,$id]);
            return back()->with('success',"Quantité mise à jour avec succés");
        }else{
            return back();
        }
    }

//==============================================suprimer au niveau du panier===================================//
    public function delete($id)
    {
        if(Auth::user()->role== Null){
            DB::delete('delete from appartenirs where idApp = ?', [$id]);
            return back()->with('success',"Produit supprimer  avec succés");
        }else{
            return back();
        }
    }
    
    
    
}