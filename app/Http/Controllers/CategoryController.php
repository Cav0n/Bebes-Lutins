<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function search(Request $request)
    {
        $search_words = preg_split('/\s+/', $request['search']);

        $found_valid_categories = array();
        $found_possible_categories = array();
        $result = array();

        $categories = Category::where('isDeleted', '!=', '1')->orderBy('name', 'asc')->get();
        $total_valid_words = count($search_words);

        foreach($categories as $category){
            $count_valid_words = 0;
            foreach($search_words as $word) {
                if (stripos(mb_strtoupper($category->name),mb_strtoupper($word)) !== false) $count_valid_words++;
            }
            if($count_valid_words == $total_valid_words) {$found_valid_categories[$category->id] = $category;}
            else if($count_valid_words > 0) $found_possible_categories[] = $category;
        }

        $result['valid_categories'] = $found_valid_categories;
        $result['possible_categories'] = $found_possible_categories;

        header('Content-type: application/json');
        echo json_encode( $result, JSON_PRETTY_PRINT);
    }

    public function getJSON(Category $category)
    {
        $category_array = array();
        $category_array['name'] = $category->name;
        $category_array['description'] = $category->description;
        $category_array['mainImage'] = $category->mainImage;
        $category_array['rank'] = $category->rank;
        $category_array['isHidden'] = $category->isHidden;
        $category_array['isDeleted'] = $category->isDeleted;
        $category_array['parent_id'] = $category->parent_id;
        $category_array['created_at'] = $category->created_at;
        $category_array['updated_at'] = $category->updated_at;
        $category_array['images'] = $category->images;

        $products = array();

        foreach($category->products as $product){ $products[] = ['id'=>$product->id, 'name'=>$product->name]; } 
        foreach($category->childs as $child){
            foreach($child->products as $product){ $products[] = ['id'=>$product->id, 'name'=>$product->name]; }
            foreach ($child->childs as $subchild) {
                foreach($subchild->products as $product){ $products[] = ['id'=>$product->id, 'name'=>$product->name]; }
            }
        }

        $data = [ 
            'category' => $category_array,
            'products' => $products
        ];

        header('Content-type: application/json');
        echo json_encode( $data );
    }

    /**
     * @param  \App\Category  $category
     * Switch 'IsHidden' attribute to hide or not category.
     */
    public function switchIsHidden(Category $category)
    {
        $category->isHidden = !$category->isHidden;
        $category->save();
    }

    /**
     * @param \App\Category $category
     * @param int $rank
     * Update rank for a category
     */
    public function updateRank(Category $category, int $rank)
    {
        $category->rank = $rank;
        $category->save();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_categories = Category::where('isDeleted', 0)->orderBy('name', 'asc')->get();
        return view('pages.dashboard.categories.creation')->withCategories($all_categories);
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
            'parent_id' => 'string|nullable',
            'description' => 'string|min:10|required',
            'rank' => 'integer|min:0|required',
            'tags' => 'nullable',
            'main_image_name' => 'required',
            'is-hidden' => 'nullable',
        ]);

        $mainImageName = $request['main_image_name'];

        $category = new Category();
        $category->name = $request['name'];
        $category->description = $request['description'];
        $category->rank = $request['rank'];
        if($request['is-hidden'] != null) $category->isHidden = true;
        if($request['parent_id'] != 'null') $category->parent_id = $request['parent_id'];
        $category->save();

        //MAIN IMAGE
        rename(public_path('images/tmp/').$mainImageName, public_path('images/categories/').$mainImageName); // MOVE MAIN IMAGE FROM TMP TO REAL FOLDER
        $mainImage = new Image();
        $mainImage->name = $mainImageName;
        $mainImage->size = filesize(public_path('images/categories/').$mainImageName);
        $mainImage->save();

        $category->images()->attach($mainImage->id);
        $category->mainImage = $mainImage->name;

        //TAGS
        if($request->tags != null){
            foreach(\json_decode($request->tags) as $r_tag){
                if(Tag::where('name', $r_tag->value)->exists()) $tag = Tag::where('name', $r_tag->value)->first();
                else $tag = new Tag();
                $tag->name = $r_tag->value;
                $tag->save();

                $category->tags()->attach($tag->id);
            }
        }

        $category->save();
        return redirect('/dashboard/produits/categories/edition/'.$category->id)->with('success-message', 'La catégorie a été créée avec succés.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('pages.categories.category')->withCategory($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('isDeleted', 0)->orderBy('name', 'asc')->get();
        return view('pages.dashboard.categories.edition')->withCategory($category)->withCategories($categories);
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
        $request->validate([
            'name' => 'string|min:3|required',
            'parent_id' => 'string|nullable',
            'description' => 'string|min:10|required',
            'rank' => 'integer|min:0|required',
            'tags' => 'nullable',
            'main_image_name' => 'required',
            'is-hidden' => 'nullable',
        ]);

        $mainImageName = $request['main_image_name'];

        $category->name = $request['name'];
        $category->description = $request['description'];
        $category->rank = $request['rank'];
        if($request['is-hidden'] != null) $category->isHidden = true;
        if($request['parent_id'] != 'null') $category->parent_id = $request['parent_id'];
        $category->save();

        //MAIN IMAGE
        if($category->mainImage != $mainImageName){
            unlink(public_path('images/categories/').$category->mainImage);
            $category->images()->detach();

            rename(public_path('images/tmp/').$mainImageName, public_path('images/categories/').$mainImageName); // MOVE MAIN IMAGE FROM TMP TO REAL FOLDER
            $mainImage = new Image();
            $mainImage->name = $mainImageName;
            $mainImage->size = filesize(public_path('images/categories/').$mainImageName);
            $mainImage->save();

            $category->images()->attach($mainImage->id);
            $category->mainImage = $mainImage->name;
        }

        

        //TAGS
        $category->tags()->detach(); 
        if($request->tags != null){
            foreach(\json_decode($request->tags) as $r_tag){
                if(Tag::where('name', $r_tag->value)->exists()){ // IF tag already exists in database
                    $tag = Tag::where('name', $r_tag->value)->first();
                    $category->tags()->attach($tag->id);// Add the tag to the category

                } else { // Else create a new tag and attach it to category
                    $tag = new Tag();
                    $tag->name = $r_tag->value;
                    $tag->save();   
                    $category->tags()->attach($tag->id); 
                }
            }
        }

        $category->save();
        return redirect('/dashboard/produits/categories/edition/'.$category->id)->with('success-message', 'La catégorie a été mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        echo "TODO";
    }
}
