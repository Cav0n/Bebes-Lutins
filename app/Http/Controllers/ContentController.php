<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;

class ContentController extends Controller
{
    const CONTENT_TYPE = ['CONTENT', 'LINK', 'EMAIL', 'TEL', 'TEXT'];

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

        $contents = Content::orderBy('title')->get();
        $title = 'Contenus';

        if (isset($request['footer_element_id'])) {
            $selectedContents = [];

            foreach ($contents as $content) {
                $content->footerElements()
                    ->wherePivot('footer_element_id', $request['footer_element_id'])
                    ->exists() ? $selectedContents[] = $content : null;
            }

            $contents = $selectedContents;
            $title = \App\FooterElement::where('id', $request['footer_element_id'])->first()->title;
        }


        return view('pages.admin.contents')->withContents($contents)->withCardTitle($title);
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
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        return view('pages.static.content')->with('content', $content);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        return view('pages.admin.content')->with('content', $content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        $request->validate([
            'type' => ['required', ValidationRule::in(self::CONTENT_TYPE)],
            'title' => ['required', 'min:3']
        ]);

        $content->title = $request['title'];
        $content->type = $request['type'];

        switch ($request['type']) {
            case 'LINK':
                $content->url = 'http://' . $request['url'];
            break;

            case 'EMAIL':
                $content->url = 'mailto:' . preg_replace('/\s+/', '', $request['title']);
            break;

            case 'TEL':
                $content->url = 'tel:' . preg_replace('/\s+/', '', $request['title']);
            break;

            case 'CONTENT':
                $content->url = '/content/' . $content->id;
            break;

            case 'TEXT':
                $content->url = null;
            break;
        }

        if ('CONTENT' === $request['type']) {
            foreach ($request['section'] as $r){
                if (\App\ContentSection::where('title', $r['title'])->exists()) {
                    $section = \App\ContentSection::where('title', $r['title'])->first();
                } else {
                    $section = new \App\ContentSection();
                }

                $section->title = $r['title'];
                $section->text = $r['text'];
                $section->save();
            }
        }

        $content->save();
        return back()->with('successMessage', "Contenu sauvegardé avec succés !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
