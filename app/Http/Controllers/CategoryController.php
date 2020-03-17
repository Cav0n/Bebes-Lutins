<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return view('pages.admin.categories', ['categories' => $categories]);
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
}
