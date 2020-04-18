<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class ReviewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ReviewController
    |--------------------------------------------------------------------------
    |
    | This controller handle Review model.
    |
    */

    public function __construct()
    {
        $this->middleware('admin')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = \App\Review::paginate('15');

        return view('pages.admin.reviews')->with('reviews', $reviews);
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
    public function store(Request $request, \App\Product $product)
    {
        $request->validate([
            'title' => 'required|min:3|max:100',
            'text' => 'required|min:10',
            'mark' => 'required|numeric'
        ]);

        $review = new Review();
        $review->product_id = $product->id;
        $review->user_id = Auth::check() ? Auth::user()->id : null;
        $review->title = $request['title'];
        $review->text = $request['text'];
        $review->mark = $request['mark'];
        $review->save();

        return back()->with('ratingSuccessMessage', 'Votre commentaire a bien été sauvegardé');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
