<?php

namespace App\Http\Controllers;

use Storage;
use App\Product;
use App\Category;
use App\Image;
use App\Tag;
use App\ProductCharacteristic;
use App\ProductCharacteristicOption;
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

    public function correctAllMainImages()
    {
        $products = Product::all();
        foreach($products as $product){
            $oldMainImageName = $product->mainImage;
            $newMainImageName = \App\Image::removeSpecialCharacters($oldMainImageName);
            echo '<p>'.$oldMainImageName . ' --- ' . $newMainImageName.'</p><br>' ;
            $product->mainImage = $newMainImageName;
            $product->save();

            foreach($product->images as $image){
                if($image->name == $oldMainImageName){
                    $image->name = $newMainImageName;
                    $image->save();
                }
            }

            if(file_exists(public_path('/images/products/thumbnails/') . $oldMainImageName)){
                rename(public_path('/images/products/') . $oldMainImageName, 
                    public_path('/images/products/') . $newMainImageName);
            }
        }
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
            return view('pages.products.all-products')->withProducts(Product::where('isHidden', 0)->where('isDeleted', 0)->paginate(16));
        } else {
            if(count(session()->get("selected-categories")) == 0) return view('pages.products.all-products')->withProducts(Product::where('isHidden', 0)->where('isDeleted', 0)->paginate(16));
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
        $request->validate([
            'name' => 'string|min:3|required',
            'description' => 'string|min:10|required',
            'stock' => 'integer|min:0|required',
            'price' => 'numeric|min:0.01|required',
            'tags' => 'nullable',
            'main_image_name' => 'required',
            'thumbnails_names' => 'array|nullable',
            'is-hidden' => 'nullable',
            'characteristics' => 'array|nullable',
        ]);

        $mainImageName = $request['main_image_name'];

        $product = new Product();
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->stock = $request['stock'];
        $product->price = $request['price'];
        if($request['is-hidden'] != null) $product->isHidden = true;
        $product->save();

        //MAIN IMAGE
        rename(public_path('images/tmp/').$mainImageName, public_path('images/products/').$mainImageName); // MOVE MAIN IMAGE FROM TMP TO REAL FOLDER
        $mainImage = new Image();
        $mainImage->name = $mainImageName;
        $mainImage->size = filesize(public_path('images/products/').$mainImageName);
        $mainImage->save();
        $product->images()->attach($mainImage->id);
        $product->mainImage = $mainImage->name;

        //CATEGORIES
        if($request->categories != null){
            foreach(\json_decode($request->categories) as $r_category){
                $category = Category::where('name', $r_category->value)->first();
                $product->categories()->attach($category->id);
            }
        }

        //THUMBNAILS
        if($request['thumbnails_names'] != null){
            foreach ($request['thumbnails_names'] as $thumbnail_name) { // MOVE EACH THUMBNAILS FROM TMP TO REAL FOLDER
                if($thumbnail_name != ''){
                    rename(public_path('images/tmp/').$thumbnail_name, public_path('images/products/thumbnails/').$thumbnail_name);
                    $thumbnail = new Image();
                    $thumbnail->name = $thumbnail_name;
                    $thumbnail->size = filesize(public_path('images/products/thumbnails/').$thumbnail_name);
                    $thumbnail->save();
                    $product->images()->attach($thumbnail->id);
                }
            }
        }

        //TAGS
        if($request->tags != null){
            foreach(\json_decode($request->tags) as $r_tag){
                if(Tag::where('name', $r_tag->value)->exists()) $tag = Tag::where('name', $r_tag->value)->first();
                else $tag = new Tag();
                $tag->name = $r_tag->value;
                $tag->save();
                $product->tags()->attach($tag->id);
            }
        } 

        //CHARACTERISTICS
        if($request['characteristics'] != null){
            foreach($request['characteristics'] as $r_characteristic){
                $characteristic = new ProductCharacteristic();
                $characteristic->name = $r_characteristic['name'];
                $characteristic->product_id = $product->id;
                $characteristic->save();
                foreach($r_characteristic['options'] as $r_option){
                    $option = new ProductCharacteristicOption();
                    $option->name = $r_option;
                    $option->product_characteristic_id = $characteristic->id;
                    $option->save();
                }
            }
        }

        $product->save();
        return redirect('/dashboard/produits/edition/'.$product->id)->with('success-message', 'Le produit a été crée avec succés.');
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
        return view('pages.dashboard.products.edition')->withProduct($product);
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
        $request->validate([
            'name' => 'string|min:3|required',
            'description' => 'string|min:10|required',
            'stock' => 'integer|min:0|required',
            'price' => 'numeric|min:0.01|required',
            'tags' => 'nullable',
            'main_image_name' => 'required',
            'thumbnails_names' => 'array|nullable',
            'is-hidden' => 'nullable',
            'characteristics' => 'array|nullable',
        ]);

        $mainImageName = $request['main_image_name'];
        
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->stock = $request['stock'];
        $product->price = $request['price'];
        if($request['is-hidden'] != null) $product->isHidden = true;
        $product->save();

        //MAIN IMAGE
        if($product->mainImage != $mainImageName){
            unlink(public_path('images/products/').$product->mainImage);
            $product->images()->detach();

            rename(public_path('images/tmp/').$mainImageName, public_path('images/products/').$mainImageName); // MOVE MAIN IMAGE FROM TMP TO REAL FOLDER
            $mainImage = new Image();
            $mainImage->name = $mainImageName;
            $mainImage->size = filesize(public_path('images/products/').$mainImageName);
            $mainImage->save();
            $product->images()->attach($mainImage->id);
            $product->mainImage = $mainImage->name;
        }

        //THUMBNAILS
        if($request['thumbnails_names'] != null){
            foreach ($request['thumbnails_names'] as $thumbnail_name) { // MOVE EACH THUMBNAILS FROM TMP TO REAL FOLDER
                rename(public_path('images/tmp/').$thumbnail_name, public_path('images/products/thumbnails/').$thumbnail_name);
                $thumbnail = new Image();
                $thumbnail->name = $thumbnail_name;
                $thumbnail->size = filesize(public_path('images/products/thumbnails/').$thumbnail_name);
                $thumbnail->save();
                $product->images()->attach($thumbnail->id);
            }
        }

        //TAGS
        $product->tags()->detach(); 
        if($request->tags != null){
            foreach(\json_decode($request->tags) as $r_tag){
                if(Tag::where('name', $r_tag->value)->exists()){ // IF tag already exists in database
                    $tag = Tag::where('name', $r_tag->value)->first();
                    $product->tags()->attach($tag->id);// Add the tag to the category

                } else { // Else create a new tag and attach it to category
                    $tag = new Tag();
                    $tag->name = $r_tag->value;
                    $tag->save();   
                    $product->tags()->attach($tag->id); 
                }
            }
        }

        //CHARACTERISTICS
        foreach($product->characteristics as $characteristic){
            foreach($characteristic->options as $option){
                $option->delete();
            }
            $characteristic->delete();
        }
        if($request['characteristics'] != null){
            foreach($request['characteristics'] as $r_characteristic){
                $characteristic = new ProductCharacteristic();
                $characteristic->name = $r_characteristic['name'];
                $characteristic->product_id = $product->id;
                $characteristic->save();
                foreach($r_characteristic['options'] as $r_option){
                    $option = new ProductCharacteristicOption();
                    $option->name = $r_option;
                    $option->product_characteristic_id = $characteristic->id;
                    $option->save();
                }
            }
        }

        $product->save();
        return redirect('/dashboard/produits/edition/'.$product->id)->with('success-message', 'Le produit a été crée avec succés.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->isDeleted = true;
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
