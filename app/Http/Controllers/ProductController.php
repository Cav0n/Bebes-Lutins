<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function getJSON(Product $product)
    {
        $product_array = array();
        $product_array['name'] = $product->name;
        $product_array['description'] = $product->description;
        $product_array['mainImage'] = $product->mainImage;
        $product_array['stock'] = $product->stock;
        $product_array['price'] = $product->price;
        $product_array['isHidden'] = $product->isHidden;
        $product_array['isDeleted'] = $product->isDeleted;
        $product_array['creationDate'] = $product->creationDate;
        $product_array['reviewsCount'] = $product->reviewsCount;
        $product_array['reviewsStars'] = $product->reviewsStars;
        $product_array['created_at'] = $product->created_at;
        $product_array['updated_at'] = $product->updated_at;
        $product_array['images'] = $product->images;

        $data = [ 'product' => $product_array ];

        header('Content-type: application/json');
        echo json_encode( $data );
    }

    /**
     * Switch 'IsHidden' attribute to hide or not product.
     */
    public function switchIsHidden(Product $product)
    {
        $product->isHidden = !$product->isHidden;
        $product->save();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( (!$request->session()->has("selected-categories")) ){
            return view('pages.products.all-products')->withProducts(Product::where('isHidden', 0)->paginate(16));
        } else {
            if(count(session()->get("selected-categories")) == 0) return view('pages.products.all-products')->withProducts(Product::where('isHidden', 0)->paginate(16));
            $selected_categories = Category::whereIn('id',session()->get("selected-categories"))->get();
            $products = array();

            foreach ($selected_categories as $category){
                foreach($category->products as $product){ $products[] = $product; } 
                foreach($category->childs as $child){
                    foreach($child->products as $product){ $products[] = $product; }
                    foreach ($child->childs as $subchild) {
                        foreach($subchild->products as $product){ $products[] = $product; }
                    }
                }
            }

            $perPage = 16;   
            $currentPage = $request['page'];
            if ($currentPage > count($products) or $currentPage < 1) { $currentPage = 1; }
            $offset = ($currentPage * $perPage) - $perPage;
            $perPageProducts = array_slice($products,$offset,$perPage);

            $productsPaginated = new LengthAwarePaginator($perPageProducts, count($products), $perPage, $currentPage);
            $productsPaginated->withPath('/produits');

            return view('pages.products.all-products')->withProducts($productsPaginated);;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.products.creation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category $category
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Product $product)
    {
        return view('pages.products.product')->withProduct($product)->withCategory($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        echo 'Page d\'édition du produit';
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
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        echo "TODO";
    }

    public function add_selected_category(Category $category){
        $selected_categories = array();
        $selected_categories[] = $category->id;
        session(['selected-categories' => $selected_categories]);
    }

    public function unselected_category(Category $category){
        $selected_categories = session('selected-categories');
        if ($selected_categories != null){
            if (($key = array_search($category->id, $selected_categories)) !== false) {
                unset($selected_categories[$key]);
            }
            $selected_categories = array_values($selected_categories); 
            session(['selected-categories' => $selected_categories]);
        }
        
    }
}
