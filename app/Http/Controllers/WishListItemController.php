<?php

namespace App\Http\Controllers;

use Auth;
use App\WishList;
use App\WishListItem;
use App\Product;
use Illuminate\Http\Request;

class WishListItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('wishlist');
    }

    public function checkIfProductIsInWishlist(Request $request)
    {
        $wishlist_id = $request['wishlist_id'];
        $product_id = $request['product_id'];

        if(WishList::where('id', $wishlist_id)->exists()){
            if(WishListItem::where('wish_list_id', $wishlist_id)->where('product_id', $product_id)->exists()){
                $response['message'] = "Le produit est dans la liste.";
                $response['result'] = true;
                $response['code'] = 200;
            } else {
                $response['message'] = "Le produit n'est pas dans la liste.";
                $response['result'] = false;
                $response['code'] = 200;
            }
        } else {
            $response['message'] = "La liste n'existe pas.";
            $response['code'] = 300;
        }

        return response()->json($response, $response['code']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        if(! WishListItem::where('wish_list_id', Auth::user()->wishlist()->first()->id)->where('product_id', $product->id)->exists()){
            $wishListItem = new WishListItem();
            $wishListItem->product_id = $product->id;
            $wishListItem->wish_list_id = Auth::user()->wishlist->id;
            $wishListItem->save();

            $response['message'] = "Le produit à bien été ajouté à votre liste d'envie.";
            $response['code'] = 200;
        } else {
            $response['message'] = "Le produit est déjà dans votre liste d'envie.";
            $response['code'] = 301;
        }

        return response()->json($response, $response['code']);
    }

    public function checkExistingWishList(Request $request, Product $product){
        if(Auth::check() && Auth::user()->wishlist != null){
            $this->store($request, $product);
        } else if(Auth::check() && Auth::user()->wishlist == null){
            $response['message'] = "Vous n'avez pas de liste d'envie active.";
            $response['code'] = 301;
        } else {
            $response['message'] = "Vous devez être connecté pour ajouter un article à votre liste d'envie.";
            $response['code'] = 300;
        }

        return response()->json($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WishListItem  $wishListItem
     * @return \Illuminate\Http\Response
     */
    public function show(WishListItem $wishListItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WishListItem  $wishListItem
     * @return \Illuminate\Http\Response
     */
    public function edit(WishListItem $wishListItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WishListItem  $wishListItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishListItem $wishListItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WishListItem  $wishListItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        WishListItem::where('wish_list_id', $request['wishlist_id'])->where('product_id', $request['product_id'])->delete();

        $response['message'] = "Le produit a été supprimé de votre liste d'envie";
        $response['code'] = 200;

        return response()->json($response, $response['code']);
    }
}
