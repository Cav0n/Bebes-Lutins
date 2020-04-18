<?php

namespace App\Http\Controllers;

use App\Content;
use App\ContentSection;
use App\FooterElement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PHPUnit\Util\Json;

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

    public static function createFromLocalJSON()
    {
        $path = \base_path('config/contents.json');

        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $fe) {
            $footerElement = new FooterElement();
            $footerElement->title = $fe['title'];
            $footerElement->position = $fe['position'];

            $footerElement->save();

            foreach ($fe['contents'] as $co) {
                $content = new Content();
                $content->title = $co['title'];
                $content->url = $co['url'];
                $content->type = $co['type'];

                $content->save();

                $content->footerElements()->attach($footerElement);

                foreach ($co['sections'] as $se) {
                    $section = new ContentSection();
                    $section->title = $se['title'];
                    $section->text = $se['text'];
                    $section->content_id = $content->id;

                    $section->save();
                }
            }
        }

        echo "All contents has been created !";
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
