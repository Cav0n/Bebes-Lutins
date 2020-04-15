<?php

namespace App\Http\Controllers;

use App\FooterElement;
use Illuminate\Http\Request;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class FooterElementController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FooterElementController
    |--------------------------------------------------------------------------
    |
    | This controller handle FooterElement model.
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
    public function index()
    {
        $footerElements = FooterElement::orderBy('position')->get();
        $title = 'Bas de page';

        return view('pages.admin.footer_elements')->withFooterElements($footerElements)->withCardTitle($title);
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
     * @param  \App\FooterElement  $footerElement
     * @return \Illuminate\Http\Response
     */
    public function show(FooterElement $footerElement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FooterElement  $footerElement
     * @return \Illuminate\Http\Response
     */
    public function edit(FooterElement $footerElement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FooterElement  $footerElement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FooterElement $footerElement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FooterElement  $footerElement
     * @return \Illuminate\Http\Response
     */
    public function destroy(FooterElement $footerElement)
    {
        //
    }
}
