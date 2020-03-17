<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name', 'asc')->get();

        return view('pages.admin.products')->withProducts($products);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('pages.product.index')->withProduct($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.admin.product')->withProduct($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            $request['categories'] = json_decode($request['categories']);
        } catch (Exception $e) {
            return back()->withErrors('categories', 'Veuillez ajouter au moins une catégorie au produit.');
        }

        $request->validate([
            'name' => 'required|min:5|unique:products,name,'.$product->id,
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0.01',
            'promoPrice' => 'required_with:isInPromo|nullable|numeric|min:0.01',
            'stock' => 'required|numeric|min:0',
        ]);

        if (null === $request['isInPromo']) {
            $request['promoPrice'] = null;
        }

        if (null === $request['visible']) {
            $request['visible'] = false;
        } else $request['visible'] = true;

        $product->categories()->detach();
        foreach ($request['categories'] as $category) {
            $product->categories()->attach(\App\Category::where('name', $category->value)->first());
        }

        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->promoPrice = $request['promoPrice'];
        $product->stock = $request['stock'];
        $product->isHidden = !$request['visible'];

        $product->save();

        return redirect()->route('admin.product.edit', ['product' => $product])
                         ->with('successMessage', 'Produit édité avec succés !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function apiGet(Product $product)
    {
        return new \App\Http\Resources\Product($product->id);
    }
}
