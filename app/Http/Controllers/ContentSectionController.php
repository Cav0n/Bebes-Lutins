<?php

namespace App\Http\Controllers;

use App\ContentSection;
use Illuminate\Http\Request;

class ContentSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Content $content)
    {
        $sections = $content->sections;
        $title = 'Sections de contenu';

        return view('pages.admin.sections')->withSections($sections)->withContent($content)->withCardTitle($title);
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
     * @param  \App\ContentSection  $contentSection
     * @return \Illuminate\Http\Response
     */
    public function show(ContentSection $contentSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContentSection  $contentSection
     * @return \Illuminate\Http\Response
     */
    public function edit(ContentSection $contentSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContentSection  $contentSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentSection $contentSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContentSection  $contentSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentSection $contentSection)
    {
        //
    }
}
