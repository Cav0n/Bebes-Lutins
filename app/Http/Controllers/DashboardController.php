<?php

namespace App\Http\Controllers;

use DB;
use \App\Order;
use \App\Product;
use \App\Category;
use \App\User;
use \App\Review;
use \App\Voucher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        return redirect('/dashboard/commandes');
    }

    public function changelog()
    {
        return view('pages.dashboard.changelog');
    }

    public function orders(string $status = null){
        if(session()->has('selected_order_status' . $status)){
            $orders = Order::where('status', '=', session('selected_order_status'.$status))->orderBy('created_at', 'desc')->paginate(15); }
        
        session(['no_status' => false]);
        
        switch($status){
            case null:
                if(!isset($orders)){
                    $orders = Order::where('id', '!=', null)->where('status', '!=', -3)->orderBy('created_at', 'desc')->paginate(20); 
                    session(['no_status' => true]);
                }
                $old_status = $status;
                break;
            case 'en-cours':
                if(!isset($orders)){
                    $orders = Order::where('status', '>=', 0)->where('status', '!=', 3)->where('status', '!=', '33')->orderBy('created_at', 'desc')->paginate(15); }
                $old_status = $status;
                $status = "en cours";
                break;

            case 'terminees':
                if(!isset($orders)){
                    $orders = Order::where('status', '!=', 22)->where('status', '>=', 3)->orderBy('created_at', 'desc')->paginate(15); }
                $old_status = $status;
                $status = "terminées";
                break;

            case 'refusees':
                if(!isset($orders)){
                    $orders = Order::where('status', '=', -3)->paginate(15); }
                $old_status = $status;
                $status = "refusées";
                break;

            default:
                session(['no_status' => true]);
                return redirect('/dashboard/commandes/en-cours');
                break;
        }
        
        return view('pages.dashboard.orders')->withStatus($status)->withOrders($orders)->withOldStatus($old_status);
    }

    public function products(Request $request){
        $productsToDisplay = Product::where('isDeleted', '!=', '1')->orderBy('name', 'asc')->paginate(20);

        $productsToVerify = Product::where('isDeleted', '!=', '1')->orderBy('name', 'asc')->get();
        
        $productsWithMissingMainImage = array();
        $productsWithMissingThumbnails = array();

        foreach($productsToVerify as $product){
            if(! $product->mainImageExists()){
                $productsWithMissingMainImage[] = $product;}
            if(! $product->thumbnailsExists()){
                $productsWithMissingThumbnails[] = $product;}
        }

        return view('pages.dashboard.products')
            ->withProducts($productsToDisplay)
            ->withProductsWithMissingMainImage($productsWithMissingMainImage)
            ->withProductsWithMissingThumbnails($productsWithMissingThumbnails);
    }

    public function stocks(){
        $products = Product::where('isDeleted', '!=', '1')->orderBy('name', 'asc')->paginate(20);
        return view('pages.dashboard.stocks')->withProducts($products);
    }

    public function highlighted(){
        $products = Product::where('isDeleted', 0)->orderBy('name', 'asc')->get();
        $highlighted_products = Product::where('isHighlighted', 1)->orderBy('name', 'asc')->get();
        return view('pages.dashboard.highlighted')
            ->withProducts($products)
            ->withHighlightedProducts($highlighted_products);
    }

    public function categories(){
        $categoriesToVerify = Category::where('isDeleted', '!=', '1')->orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        $categoriesToDisplay = Category::where('isDeleted', '!=', '1')->where('parent_id', null)->orderBy('rank', 'asc')->orderBy('name', 'asc')->get();
        $categoriesWithMissingMainImage = array();

        foreach($categoriesToVerify as $category){
            if(! $category->mainImageExists()){
                $categoriesWithMissingMainImage[] = $category; }
        }

        return view('pages.dashboard.categories')
            ->withCategories($categoriesToDisplay)
            ->withCategoriesWithMissingMainImage($categoriesWithMissingMainImage);
    }

    public function customers(){
        $users = User::where('id', '!=', null)->orderBy('created_at', 'desc')->paginate(20);
        return view('pages.dashboard.customers')->withUsers($users);
    }

    public function customer(User $user){
        return view('pages.dashboard.customers.customer')->withCustomer($user);
    }

    public function reviews(){
        $reviews = Review::where('id', '!=', null)->orderBy('created_at', 'desc')->paginate(20);
        return view('pages.dashboard.reviews')->withReviews($reviews);
    }

    public function vouchers(){
        $vouchers = Voucher::where('isDeleted', '0')->orderBy('dateLast', 'desc')->paginate(20);
        return view('pages.dashboard.vouchers')->withVouchers($vouchers);
    }

    public function newVoucher(){
        
    }

    public function newsletters(){

    }

    public function analytics(){
        $orders = Order::all();
        return view('pages.dashboard.analytics.analytics')->withOrders($orders);
    }

    public function select_order_status(Request $request){
        $selected_order_status = array();
        $selected_order_status = $request['status'];
        $page = $request['page'];
        session(['selected_order_status' . $page => $selected_order_status]);
    }

    public function unselect_order_status(Request $request){
        $request->session()->forget('selected_order_status' . $request['page']);
    }
}
