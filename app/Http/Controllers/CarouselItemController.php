<?php

namespace App\Http\Controllers;

use App\CarouselItem;
use Illuminate\Http\Request;

/**
 * Carousel Item Model Controller.
 * Carousel items are shown on frontoffice homepage.
 */
class CarouselItemController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CarouselItem  $carouselItem
     * @return \Illuminate\Http\Response
     */
    public function show(CarouselItem $carouselItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CarouselItem  $carouselItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CarouselItem $carouselItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CarouselItem  $carouselItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarouselItem $carouselItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarouselItem  $carouselItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarouselItem $carouselItem)
    {
        //
    }
}
