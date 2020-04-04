<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\AbstractSearchController;
use Illuminate\Http\Request;

/**
 * A search controller used in admin backoffice.
 */
class SearchController extends AbstractSearchController
{
    /*
    |--------------------------------------------------------------------------
    | [ADMIN] - Search Controller
    |--------------------------------------------------------------------------
    |
    | This controller handle search in admin dashboard.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('admin');
        parent::__construct($request);
    }

    /**
     * Order search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function orders(Request $request)
    {
        $orders = \App\Order::query();

        foreach ($this->search as $word) {
            $orders->where('trackingNumber', 'like', '%' . $word . '%');
        }

        $orders = $orders->paginate(15);
        $title = 'Commandes';
        return view('pages.admin.index')->withOrders($orders)->withInSearch(true)->withCardTitle($title);
    }

    /**
     * Product search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function products(Request $request)
    {
        $products = \App\Product::query()->where('isDeleted', 0);

        foreach ($this->search as $word) {
            $products->where('name', 'like', '%' . $word . '%');
        }

        $products = $products->paginate(15);
        $title = 'Produits';
        return view('pages.admin.products')->withProducts($products)->withInSearch(true)->withCardTitle($title);
    }

    /**
     * Category search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function categories(Request $request)
    {
        $categories = \App\Category::query()->where('isDeleted', 0);

        foreach ($this->search as $word) {
            $categories->where('name', 'like', '%' . $word . '%');
        }

        $categories = $categories->paginate(15);
        $title = 'Catégories';
        return view('pages.admin.categories')->withCategories($categories)->withInSearch(true)->withCardTitle($title);
    }

    /**
     * Customer search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function customers(Request $request)
    {
        $customers = \App\User::query();

        foreach ($this->search as $word) {
            $customers->where('firstname', 'like', '%' . $word . '%');
            $customers->orWhere('lastname', 'like', '%' . $word . '%');
            $customers->orWhere('email', 'like', '%' . $word . '%');
            $customers->orWhere('phone', 'like', '%' . $word . '%');
        }

        $customers = $customers->paginate(15);
        $title = 'Clients';
        return view('pages.admin.customers')->withCustomers($customers)->withInSearch(true)->withCardTitle($title);
    }

    /**
     * Review search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function reviews(Request $request)
    {
        $reviews = \App\Review::query();

        foreach ($this->search as $word) {
            $reviews->where('title', 'like', '%' . $word . '%');
            $reviews->orWhere('text', 'like', '%' . $word . '%');
        }

        $reviews = $reviews->paginate(15);
        $title = 'Avis clients';
        return view('pages.admin.reviews')->withReviews($reviews)->withInSearch(true)->withCardTistle($title);
    }

    /**
     * Content search
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function contents(Request $request)
    {
        $contents = \App\Content::query();

        foreach ($this->search as $word) {
            $contents->where('title', 'like', '%' . $word . '%');
        }

        $contents = $contents->paginate(15);
        $title = 'Contenus';
        return view('pages.admin.contents')->withContents($contents)->withInSearch(true)->withCardTitle($title);
    }
}
