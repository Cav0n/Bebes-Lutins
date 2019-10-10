<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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

        $childs = array();
        foreach($category->childs as $child){
            $childs[] = $child;
            foreach($child->childs as $subchild){
                $childs[] = $subchild;
            }
        }

        $products = array();
        $products[] = $category->products;
        foreach($childs as $child){
            $products[] = $child->products;
        }

        $category_array['childs'] = $childs;

        $data = [ 'category' => $category_array ];

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
        echo 'Page de création de catégorie';
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
        echo 'Page d\'édition de la catégorie';
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
        dd($request);
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
