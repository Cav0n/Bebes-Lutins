<?php

namespace App\Http\Controllers;

use App\Category;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CategoryController
    |--------------------------------------------------------------------------
    |
    | This controller handle Category model.
    |
    */

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'create', 'store', 'edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parent = (isset($request['parent'])) ? $request['parent'] : null;

        $categories = Category::where('isDeleted', 0)
                                    ->where('parentId', $parent)
                                    ->orderBy('rank', 'asc')
                                    ->paginate(15);

        $parent = isset($parent) ? Category::where('id', $parent)->first() : null;

        return view('pages.admin.categories', ['categories' => $categories, 'parent' => $parent]);
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('pages.category.index')->withCategory($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('pages.admin.category', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try {
            $request['parent'] = json_decode($request['parent']);
            $request['parent'] = $request['parent'][0]->value;
        } catch (Exception $e) {
            return back()->withErrors('parent', 'La catégorie parente n\'est pas valide.');
        }

        $request->validate([
            'name' => 'required|min:5|unique:categories,name,'.$category->id,
            'description' => 'required|min:10',
            'rank' => 'required|integer|min:0',
            'parent' => 'nullable',
        ]);

        if (null === $request['visible']) {
            $request['visible'] = false;
        } else $request['visible'] = true;

        $category->name = $request['name'];
        $category->description = $request['description'];
        $category->rank = $request['rank'];
        $category->parentId = Category::where('name', $request['parent'])->first()->id;
        $category->isHidden = !$request['visible'];

        $category->save();

        return redirect()->route('admin.category.edit', ['category' => $category])
                         ->with('successMessage', 'Catégorie éditée avec succés !');
    }

    public function updateRank(Request $request, Category $category)
    {
         $category->rank = $request['rank'];

         $category->save();

         return new JsonResponse(['message' => 'ok'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function importFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/categories');
        $result = json_decode($res->getBody());

        Category::destroy(Category::all());

        $count = 0;
        foreach($result as $r) {
            if (null === $r->id || '' === $r->id) {
                continue;
            }
            $category = new Category();
            $category->id = $r->id;
            $category->name = $r->name;
            $category->description = $r->description;
            $category->rank = $r->rank;
            $category->isHidden = $r->isHidden;
            $category->isDeleted = $r->isDeleted;
            $category->created_at = $r->created_at;
            $category->updated_at = $r->updated_at;
            $category->parentId = $r->parent_id;
            $category->save();
            $count++;
        }

        echo $count . ' categories imported !' . "\n";
    }

    public function importImagesFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/categories/images');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $image = new \App\Image();
            $image->name = $r->name;
            $image->url = '/images/categories/' . $r->name;
            $image->size = isset($r->size) ? $r->size : 0;
            $image->created_at = $r->created_at;
            $image->updated_at = $r->updated_at;
            $image->save();

            if (null !== $category = \App\Category::find($r->categoryId)) {
                $category->images()->attach($image);
            }
            $count++;
        }

        echo $count . ' category images imported !' . "\n";
    }

    public function importRelationsFromJSON()
    {
        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/categories/relations');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach($result as $r) {
            Category::find($r->category_id)->products()->detach($r->product_id);
            Category::find($r->category_id)->products()->attach($r->product_id);
            $count++;
        }

        echo $count . ' categories products relations imported !' . "\n";
    }
}
