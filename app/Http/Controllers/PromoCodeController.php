<?php

namespace App\Http\Controllers;

use App\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PromoCodeController extends Controller
{
    public function checkEligibility(Request $request)
    {
        if (null === $promoCode = PromoCode::where('code', $request['promo-code'])->first()) {
            return back()->withInput()->withErrors(['promo-code' => ['Le code promo n\'existe pas.']]);
        }

        if (! $promoCode->isActive) {
            return back()->withInput()->withErrors(['promo-code' => ['Le code existe mais est périmé ou désactivé.']]);
        }

        if (null !== $promoCode->maxUsage && $promoCode->maxUsage > 0) {
            return back()->withInput()->withErrors(['promo-code' => ['La limite d\'utilisation de ce code est de : ' . $promoCode->maxUsage]]);
        }

        $cart = \App\Cart::where('id', Session::get('shopping_cart')->id)->first();

        if ($cart->totalPrice < $promoCode->minCartPrice) {
            return back()->withInput()->withErrors(['promo-code' => ['Votre panier n\'est pas éligible pour ce code.']]);
        }

        $cart->promo_code_id = $promoCode->id;
        $cart->save();
        session()->put('shopping_cart', $cart);

        return back()->withInput()->with(['promoCodeSuccessMessage' => 'Le code a été ajouté avec succés !']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promoCodes = PromoCode::orderBy('minValidDate', 'asc');
        $title = "Code promos";

        return view('pages.admin.promo_codes')->withPromoCodes($promoCodes->paginate(15))->withCardTitle($title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.promo_code');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'min:2|required',
            'discountType' => 'required',
            'discountValue' => 'nullable|min:0',
            'minValidDate' => 'required',
            'maxValidDate' => 'required|after_or_equal:minValidDate',
            'minCartPrice' => 'nullable|min:0',
            'maxUsage' => 'nullable|min:0',
        ]);

        if ('PERCENT' === $request['discountType'] && 100 < $request['discountValue']) {
            return back()->withInput()->withErrors('Une remise de plus de 100% n\'est pas autorisée.');
        }

        $promoCode = new \App\PromoCode();
        $promoCode->code = strtoupper($request['code']);
        $promoCode->discountType = $request['discountType'];
        $promoCode->discountValue = $request['discountValue'];
        $promoCode->minValidDate = Carbon::createFromFormat('Y-m-d\TH:i', $request['minValidDate']);
        $promoCode->maxValidDate = Carbon::createFromFormat('Y-m-d\TH:i', $request['maxValidDate']);
        $promoCode->minCartPrice = $request['minCartPrice'];
        $promoCode->maxUsage = $request['maxUsage'];
        $promoCode->isActive = $request['isActive'] ? true : false;

        $promoCode->save();

        return redirect(route('admin.promoCodes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function show(PromoCode $promoCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoCode $promoCode)
    {
        return view('pages.admin.promo_code', ['promoCode' => $promoCode]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PromoCode $promoCode)
    {
        $request->validate([
            'code' => 'min:2|required',
            'discountType' => 'required',
            'discountValue' => 'nullable|min:0',
            'minValidDate' => 'required',
            'maxValidDate' => 'required|after_or_equal:minValidDate',
            'minCartPrice' => 'nullable|min:0',
            'maxUsage' => 'nullable|min:0',
        ]);

        if ('PERCENT' === $request['discountType'] && 100 < $request['discountValue']) {
            return back()->withInput()->withErrors('Une remise de plus de 100% n\'est pas autorisée.');
        }

        $promoCode->code = strtoupper($request['code']);
        $promoCode->discountType = $request['discountType'];
        $promoCode->discountValue = $request['discountValue'];
        $promoCode->minValidDate = Carbon::createFromFormat('Y-m-d\TH:i', $request['minValidDate']);
        $promoCode->maxValidDate = Carbon::createFromFormat('Y-m-d\TH:i', $request['maxValidDate']);
        $promoCode->minCartPrice = $request['minCartPrice'];
        $promoCode->maxUsage = $request['maxUsage'];
        $promoCode->isActive = $request['isActive'] ? true : false;

        $promoCode->save();

        return redirect(route('admin.promoCodes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PromoCode  $promoCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoCode $promoCode)
    {
        //
    }
}
