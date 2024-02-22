<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class CommandeController extends Controller
{
    
    //===================================retouner le formulaire de facturation=============================================//
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
                   
                    
                    //dd($total);
                    return view('order.commande',compact('paniers'));
                
            }
        }else{
            return back();
        }
    }


    //==============================================details de facturation=========================================================//
    public function DetailsFacture(Request $request)
    {
        
        if(Auth::user()->role== Null){
            if($request->session()->has('id_boutique')){
                //on recuper l'id du boutique qui est dans la session
                $boutique =  session('id_boutique'); 
                //on recuper l'utilisateur conecter
                $user = Auth::user()->id;
                  //on recuper l'id et le typeLivraison
                $livraison = $request->typeLivraison;
            
                //on recupere l'idpanier du user connecter
                $pane = DB::select('select id from paniers where user_id =?',[$user]);
            
                //on recuper tous les produits qui sont dans la table appartenir dont l'idpanier est l'idpanier du user connecter
                $produits=DB::select("SELECT * 
                                    FROM appartenirs as a
                                    LEFT JOIN produits as p ON(a.id_prod = p.id)
                                    LEFT JOIN stocks as s ON(s.id_prod = p.id)
                                    where a.id_panier=?",[$pane[0]->id]);
                //dd($produits);
                
                //on insert dans la table commande id_user et le type de livraison
                DB::insert('insert into commandes (user_id, id_boutique, typeLivraison) values (?, ?, ?)', [$user, $boutique, $livraison]);
            
                //on selection id commade de user connecter
                //$pa = DB::select('select id from commandes where user_id =?',[$user]);
                $pa= DB::table('commandes')->whereIn('user_id', [Auth::user()->id])->get(); 
                $pa =  Commande::orderBy('id', 'desc')->get();
                //dd($pa);
                // $pa =  Commande::orderBy('id', 'desc')->get();

                //ici on va boucler sur tous les produits qui sont dans la table appartenir(qui represant le panier dans notre interface)
                foreach($produits as $produits){
                //ici on recuper l'idproduit et la quantites qui est dans appartenir
                    $id = $produits->id;
                    $quantites  = $produits->quantitePanier;

                //on appelle la fonction updateStock qui permet de faire la soustraction du (quantiterStock - quantiteCommander)
                    $this->updateStock();
                    DB::insert('insert into orders (id_commande,id_prod,quantiteCom) values (?,?,?)', [$pa[0]->id,$id,$quantites]);
                //=========================on vide le panier de l'utilisateurs=======================================
                    DB::delete('delete from appartenirs where id_panier =?',[$pane[0]->id]);
                    
                } 
                return  redirect('/Validecommande');
            }
        }else{
            return back();
        }
    }


    //==================================permet de faire la soustraction du (quantiterStock - quantiteCommander)
    private function updateStock(){
        //dd($request->quantite);
        $user = Auth::user()->id;
        //on recupere l'idpanier du user connecter
        $pane = DB::select('select id from paniers where user_id =?',[$user]);
            
        $app =  DB::select("SELECT s.id,s.quantiteStock,a.quantitePanier
                            FROM appartenirs as a
                            LEFT JOIN produits as p ON(a.id_prod = p.id)
                            LEFT JOIN stocks as s ON(s.id_prod = p.id)
                            where a.id_panier=?",[$pane[0]->id]);
       //dd($app);
       foreach($app as $pa){
        //dd($pa->id);
        DB::update('update stocks set quantiteStock = '. $pa->quantiteStock - $pa->quantitePanier.' where id = ?', [$pa->id]);
   
        }
    }


   //===========================================retourne la vue validerCommande==========================================//
   public function Validecommande()
   {
       if(Auth::user()->role== Null){
           return view('order.validerCommande');
       }else{
           return back();
       }
   }
//=======================================fonction pour lister les commande================================================//
public function listerCommandes(Request $request){
    if(Auth::user()->role== Null){
        $user =  Auth::user()->id;
        $listeCommande =  DB::select("SELECT c.id,c.dateCommande, c.typeLivraison, c.statut,b.nom 
                                      FROM commandes as c
                                      INNER JOIN boutiques as b ON(c.id_boutique = b.id) 
                                      where c.user_id=?",[$user]);
                                      //dd($listeCommande);
        //$listeCommande =  Commande::orderBy('id', 'desc')->get();
        return view('order.listerCommandes',[
                    'listeCommande'=>$listeCommande,
        ]);   
    }else{
        return back();
    }
}

//===========================================fonction pour afficher les detail de chaque commande==============================//
public function afficheDetails($id){
    if(Auth::user()->role== NULL){
        // dd($id);  
        $user = Auth::user()->id; 
        $detailsCom=DB::select("SELECT p.nom,p.prix_unitaire,o.quantiteCom,p.image 
                                FROM commandes c
                                LEFT JOIN orders o ON(o.id_commande = c.id)
                                LEFT JOIN produits p ON(o.id_prod = p.id)
                                WHERE c.user_id = ? AND c.id = ?",[$user,$id]);
                                //dd($detailsCom);            
        return view('order.detailCommandes',[
            'detailsCom'=>$detailsCom,
        
        ]);
    }else{
        return back();
    }

}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommandeRequest $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        //
    }
}