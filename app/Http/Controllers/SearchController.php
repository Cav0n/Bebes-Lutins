<?php

namespace App\Http\Controllers;

use \App\Http\Controllers\AbstractSearchController;
use Illuminate\Http\Request;

/**
 * @author Florian Bernard <fbernard@openstudio.fr>
 */
class SearchController extends AbstractSearchController
{
    /*
    |--------------------------------------------------------------------------
    | SearchController
    |--------------------------------------------------------------------------
    |
    | This controller handle search in frontoffice.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Product search
     *
     * @param Request $request
     * @return array
     */
    public function products(Request $request, $products = null)
    {
        $products = (null == $products) ? \App\Product::query()->where('isDeleted', 0)->where('isHidden', 0) : $products;

        foreach ($this->search as $word) {
            $products->where('name', 'like', '%' . $word . '%');
        }

        return $products;
    }
}
