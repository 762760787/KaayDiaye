<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    //===============================Ajouter une categorie=========================//
    public function create()
    {
        if(Auth::user()->statut== 1){
            $categories = DB::select('select * from categories where user_id=?',[Auth::user()->id]);
            return view('categories.ajoutCategorie',compact('categories'));
        }else{
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Categorie $categories,StoreCategorieRequest $request)
    {
        //dd($request);
        if(Auth::user()->statut== 1){
            $categories->nomCat = $request->nomCat;
            $categories->description = $request->description;
            $categories->user_id = Auth::user()->id;
            $categories->save();
            return back()->with('success','Catégorie ajoutée avec succés');
        }else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   
    //==============================================editer une categorie=========================================
    public function edit(Categorie $categories) {
        
        if(Auth::user()->statut== 1){
            return view('categories.edit',[
                'categories'=>$categories
            ]);
        }else{
            return back();
        }
    }

    //==============================================modifier une categorie=========================================
    public function update(Categorie $categories,Request $request) {
        if(Auth::user()->statut== 1){
            $categories->nomCat = $request->nomCat;
            $categories->description = $request->description ;
            $categories->save();
            return redirect()->Route('createCategorie')->with('success','Catégorie mise à jour');
        }else{
            return back();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {   
        //
    }
}