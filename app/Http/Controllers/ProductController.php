<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ProductController
    |--------------------------------------------------------------------------
    |
    | This controller handle Product model.
    |
    */
    const ORDER_BY_NAME_ASC = 1;
    const ORDER_BY_NAME_DESC = 2;
    const ORDER_BY_PRICE_ASC = 3;
    const ORDER_BY_PRICE_DESC = 4;

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'create', 'store', 'edit', 'update']);
    }

    public function importFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/products');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $product = new Product();
            $product->id = $r->id;
            $product->name = $r->name;
            $product->reference = $r->reference;
            $product->description = $r->description;
            $product->stock = $r->stock;
            $product->price = $r->price;
            $product->isHighlighted = $r->isHighlighted;
            $product->isHidden = $r->isHidden;
            $product->isDeleted = $r->isDeleted;
            $product->created_at = $r->created_at;
            $product->updated_at = $r->updated_at;
            $product->save();
            $count++;
        }

        echo $count . ' products imported !' . "\n";
    }

    public function importImagesFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/products/images');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $image = new \App\Image();
            $image->name = $r->name;
            $image->url = '/images/products/' . $r->name;
            $image->size = isset($r->size) ? $r->size : 0;
            $image->created_at = $r->created_at;
            $image->updated_at = $r->updated_at;
            $image->save();

            if (null !== $product = \App\Product::find($r->productId)) {
                $product->images()->attach($image);
            }
            $count++;
        }

        echo $count . ' product images imported !' . "\n";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where('isDeleted', 0)->orderBy('name', 'asc');
        $title = "Produits";

        if (null !== $request['isHighlighted']) {
            $products = $products->where('isHighlighted', 1);
            $title = "Produits mis en avant";
        }

        return view('pages.admin.products')->withProducts($products->paginate(15))->withCardTitle($title);
    }

    public function publicIndex(Request $request)
    {
        $products = Product::where('isDeleted', 0)->where('isHidden', 0);

        switch ($request['sorting']) {
            case self::ORDER_BY_NAME_ASC:
                $products->orderBy('name', 'asc');
            break;

            case self::ORDER_BY_NAME_DESC:
                $products->orderBy('name', 'desc');
            break;

            case self::ORDER_BY_PRICE_ASC:
                $products->orderBy('price', 'asc');
            break;

            case self::ORDER_BY_PRICE_DESC:
                $products->orderBy('price', 'desc');
            break;

            default:
                $products->orderBy('name', 'asc');
            break;
        }

        if (isset($request['search']) && !empty($request['search'])) {
            $products = (new SearchController($request))->products($request, $products);
        }

        return view('pages.product.all')->withProducts($products->paginate(16))
                                        ->withSorting($request['sorting']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriesForTagify = '';
        $categories = \App\Category::where('isDeleted', 0)->orderBy('name', 'asc')->get();

        $first = true;
        foreach ($categories as $category) {
            if (!$first) {
                $categoriesForTagify .= ",";
            }
            $categoriesForTagify .= "'" . $category->name . "'";
            $first = false;
        }

        return view('pages.admin.product')
                    ->withProduct(null)
                    ->withCategories($categories)
                    ->withCategoriesForTagify($categoriesForTagify);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request['categories'] = json_decode($request['categories']);
        } catch (Exception $e) {
            return back()->withErrors('categories', 'Veuillez ajouter au moins une catégorie au produit.');
        }

        $request->validate([
            'name' => 'required|min:5|unique:products,name',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0.01',
            'promoPrice' => 'required_with:isInPromo|nullable|numeric|min:0.01|lt:price',
            'stock' => 'required|numeric|min:0',
        ]);

        $id = preg_replace("/[^a-zA-Z\d]+/", "",
                                preg_replace("/[\s]/", "-", trim($request['name']))
                            );

        if (null === $request['isInPromo']) {
            $request['promoPrice'] = null;
        }

        if (null === $request['visible']) {
            $request['visible'] = false;
        } else $request['visible'] = true;

        $product = new Product();

        $product->id = $id;
        $product->name = $request['name'];
        $product->reference = $request['reference'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->promoPrice = $request['promoPrice'];
        $product->stock = $request['stock'];
        $product->isHidden = !$request['visible'];

        $product->save();

        if(null != $request['categories']) {
            foreach ($request['categories'] as $category) {
                $product->categories()->attach(\App\Category::where('name', $category->value)->first());
            }
        }

        return redirect()->route('admin.product.edit', ['product' => $product])
                          ->with('successMessage', 'Produit édité avec succés !');
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
        $categories = \App\Category::where('isDeleted', 0)->orderBy('name', 'asc')->get();

        $categoriesForTagify = '';
        $productCategories = '';

        $first = true;
        foreach ($categories as $category) {
            if (!$first) {
                $categoriesForTagify .= ",";
            }
            $categoriesForTagify .= "'" . $category->name . "'";
            $first = false;
        }

        $first = true;
        foreach ($product->categories as $category) {
            if (!$first) {
                $productCategories .= ',';
            }
            $productCategories .= $category->name;
            $first = false;
        }

        return view('pages.admin.product')->withProduct($product)
                                          ->withProductCategories($productCategories)
                                          ->withCategories($categories)
                                          ->withCategoriesForTagify($categoriesForTagify);
    }

    public function editImages(Request $request, Product $product)
    {
        $categories = \App\Category::where('isDeleted', 0)->orderBy('name', 'asc')->get();

        $categoriesForTagify = '';
        $productCategories = '';

        $first = true;
        foreach ($categories as $category) {
            if (!$first) {
                $categoriesForTagify .= ",";
            }
            $categoriesForTagify .= "'" . $category->name . "'";
            $first = false;
        }

        $first = true;
        foreach ($product->categories as $category) {
            if (!$first) {
                $productCategories .= ',';
            }
            $productCategories .= $category->name;
            $first = false;
        }

        return view('pages.admin.product_images')->withProduct($product)
                                          ->withProductCategories($productCategories)
                                          ->withCategories($categories)
                                          ->withCategoriesForTagify($categoriesForTagify);
    }

    public function addImages(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'image',
        ]);

        $originalName = $request->image->getClientOriginalName();

        $path = $request->image->storeAs(
            'public/images/products', $originalName
        );

        return JsonResponse::create(['image' => asset('images/products/' . $originalName)]);
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

        if (null === $request['isInPromo']) {
            $request['promoPrice'] = null;
        }

        $request->validate([
            'name' => 'required|min:5|unique:products,name,'.$product->id,
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0.01',
            'promoPrice' => 'required_with:isInPromo|nullable|numeric|min:0.01|lt:price',
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
        $product->reference = $request['reference'];
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

    public function apiIndex(Request $request)
    {
        $products = Product::where('isDeleted', 0)->where('isHidden', 0)->orderBy('name', 'asc');
        return $products->paginate(12);
    }
}
