<?php

namespace App\Http\Controllers;

use App\Review;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
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
        $validated_data = $request->validate([
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|email:filter',
            'text' => 'required|min:10',
            'mark' => 'required|min:0|max:5|numeric',
        ]);

        $review = new Review();
        $review->customerPublicName = $validated_data['firstname'] . ' ' . substr($validated_data['lastname'], 0, 1 . '.');
        $review->customerEmail = $validated_data['email'];
        $review->text = $validated_data['text'];
        $review->mark = $validated_data['mark'];
        $review->product_id = $product->id;

        if(Auth::check()) $review->user_id = Auth::user()->id;
        else $review->user_id = null;

        $review->save();

        $request->session()->flash('review-feedback', 'Votre commentaire a été envoyé.');

        Mail::to($review->customerEmail)->send(new \App\Mail\ReviewPosted($review));
        Mail::to("contact@bebes-lutins.fr")->send(new \App\Mail\ReviewPostedAdministrationNotification($review));

        return redirect('/produits/' . $product->id)->withProduct($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return view('pages/dashboard/reviews/review')->withReview($review);
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
        if($request['options'] == 'delete_response'){
            $review->adminResponse = null;
            $review->save();
            $request->session()->flash('success-message', 'La réponse à bien été supprimée.');
        } else {
            $validated_data = $request->validate([
                'admin-response' => 'required',
            ]);

            $review->adminResponse = $validated_data['admin-response'];
            $review->save();
            $request->session()->flash('success-message', 'La réponse à bien été mis à jour.');
        }
        return redirect("/dashboard/clients/avis/" . $review->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect("/produits/".$review->product_id);
    }
}
