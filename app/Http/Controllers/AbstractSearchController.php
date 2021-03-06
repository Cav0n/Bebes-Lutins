<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
/**
 * An abstract controller to handle search.
 * You must extends this controller to make custom search.
 */
class AbstractSearchController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AbstractSearchController
    |--------------------------------------------------------------------------
    |
    | This controller handle search.
    |
    */

    /** @var array $search */
    protected $search;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->prepareSearch($request);
    }

    /**
     * Prepare searched words.
     * Explode searched words in an array.
     *
     * @return void
     */
    protected function prepareSearch(Request $request)
    {
        if (!$request['search']) {
            return back()->withErrors(['search' => 'La recherche ne peut pas être vide.']);
        }

        $this->search = explode(' ', trim($request['search']));
    }
}
