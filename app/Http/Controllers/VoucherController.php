<?php

namespace App\Http\Controllers;

use App\Voucher;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(Voucher::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('isDeleted', 0)->where('stock', '>', 0)->get();
        $categories = Category::where('isDeleted', 0)->get();
        return view('pages.dashboard.vouchers.creation')->withProducts($products)->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'code' => 'min:4|required', 
            'type' => 'required',
            'value' => 'required_unless:type,3',
            'first-date' => 'date_format:d/m/Y H:i|required',
            'last-date' => 'date_format:d/m/Y H:i|required',
            'minimal-price' => 'numeric|nullable',
            'max-usage' => 'numeric|nullable',
            'availability' => 'required'
        ]);

        if($validated_data['first-date'] > $validated_data['last-date']){
            $request->session()->flash('error-first-date', 'Le début de validité ne peut pas être après la fin de validité');
            return back();
        }

        $voucher = new Voucher();
        $voucher->id = substr(uniqid(), 0, 10);
        $voucher->code = $validated_data['code'];
        $voucher->discountValue = $validated_data['value'];
        $voucher->discountType = $validated_data['type'];
        $voucher->dateFirst = Carbon::createFromFormat('d/m/Y H:i',$validated_data['first-date']);
        $voucher->dateLast = Carbon::createFromFormat('d/m/Y H:i',$validated_data['last-date']);
        $voucher->minimalPrice = $validated_data['minimal-price'];
        $voucher->maxUsage = $validated_data['max-usage'];
        $voucher->availability = $validated_data['availability'];

        $voucher->save();
        return redirect('/dashboard/reductions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        dd($voucher);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        dd('CREER LA VUE D EDITION');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        dd($request . "<BR>" . $voucher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        dd($voucher);
    }
}
