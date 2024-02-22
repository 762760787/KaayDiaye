<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Boutique;
use App\Models\Panier;

class UserController extends Controller
{

 /**
     * Display a listing of the resource.
     */
    //================================// Acueil visiteur
    public function index()
    {
        $boutiques = Boutique::all();
        return view('indexVisiteur',compact('boutiques'));
    }
  
    //=========================// acceder a un boutique====================
    public function indexVisiteurInterne(Request $request,$id)
    {
        $produits = DB::SELECT("SELECT p.id, p.nom as nomprod, p.id_cat,p.image, p.prix_unitaire, p.libelle, 
                                      s.quantiteStock, s.quantiteMinim, s.id_prod, s.id_boutique, b.nom
                                      FROM produits p, stocks s, boutiques b
                                      WHERE s.id_prod = p.id 
                                      AND s.id_boutique = b.id
                                      AND s.id_boutique = ?",[$id]);
        //dd($produits);
        return view('indexVisiteurInterne',compact('produits'));
    }
    
//===================================retourn le formulaire d'inscription du client=================//
    public function login()
    {
        return view('users.register');
    }
//======================================Enregistrement du boutiquer=================================//
    public function handleRegistration(User $user, Request $request)
    {
        //dd($request);
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;
        $user->password = Hash::make($request->password);
        $user->save();

        $user = $user->id;
        $pan=DB::insert('insert into paniers (user_id) values (?)', [$user]);
        
        return redirect()->back()->with('success','Votre compte a été créé avec');
    }

//================================Formulaire d'Inscription du boutique==========================//
    public function register()
    {
        return view('users.registerBoutiquer');
    }
//================================methonde d'erengistrement du Boutiquer=======================//
    public function RegistrationBoutiquer(User $user, Request $request)
    {
        //dd($request);
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->statut = 1;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;
        $user->password = Hash::make($request->password);
        $user->save();
        $user = $user->id;
        $img =null;
        $sigle =null;
        $pan=DB::insert('insert into boutiques (image, nom, sigle, email, adresse, telephone,user_id) values (?, ?, ?, ?, ?, ?, ?)', 
                                                [$img,$request->nom,$sigle,$request->email,$request->adresse,$request->telephone,$user]);
        
        return redirect()->back()->with('success','Votre compte a été créé avec');
    }
//==================================connexion d'un utilisateur=================================//
    public function handleLogin(Request $request)
    {
       
       $credentials =  $request->validate([
            'email'=>['required','email'],
            'password'=> ['required'],
       ]);
       
       if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
             session();
              
            if(Auth::user()->role === NULL && Auth::user()->statut == 0){
                return redirect('/accueil');
                
            }elseif(Auth::user()->statut == 1){
                return redirect()->Route('indexBoutiquer');
            }elseif( Auth::user()->statut == 2){
                return redirect()->Route('pagePharmacie');
            }elseif(Auth::user()->statut == 0){
                return back()->with('error','Votre compte n\'a pas été validé. Veuillez patienter');
            }else{
                return redirect('/');
            }
            
        }else{
          return redirect()->back()->with('error','login ou mot de passe incorrecte');
        }
        
    }
//======================================deconnexion d'un utilisateur===========================//
    public function logout()
    {
        if(Auth::user()->role === NULL && Auth::user()->statut == 0){
           
            Session::flush();
            Auth::logout();
            return redirect('register');
        }else{
           
            Session::flush();
            Auth::logout();
            return redirect('login');
        }

    }
    
    
 
    
    
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}