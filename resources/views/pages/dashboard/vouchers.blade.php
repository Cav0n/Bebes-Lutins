@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Réductions
        </h1>
    </div>
    <div class="card-body">
        <form action="/dashboard/produits/recherche" method="POST">
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <input type="text" name="search" id="search-bar" class="form-control" placeholder="Rechercher un client" aria-describedby="helpSearch">
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary w-100 border-light">Rechercher</button>
                </div>
            </div>
        </form>
        {{$vouchers->links()}}        
        <table class="table">
            <thead>
                <tr>
                    <th class='border-top-0'>Code</th>
                    <th class='border-top-0'>Type</th>
                    <th class='border-top-0'>Réduction</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $voucher)
                <tr onclick='load_url("/dashboard/vouchers/{{$voucher->id}}")' class='@if(Carbon\Carbon::now() > $voucher->dateLast) text-danger @endif @if(Carbon\Carbon::now() < $voucher->dateFirst) text-muted @endif'>
                    <td scope="row" class='font-weight-bold'>
                        {{$voucher->code}}
                        @if(Carbon\Carbon::now() > $voucher->dateLast) <span class="badge badge-danger">Éxpiré</span> @endif
                        @if(Carbon\Carbon::now() < $voucher->dateFirst) <span class="badge badge-warning">Programmé</span> @endif                        
                    </td>
                    <td>{{$voucher->discountType}}</td>
                    <td>{{$voucher->discountValue}}</td>
                    <td><small class='text-center'>{{$voucher->dateFirst->formatLocalized('%e %B %Y')}}<BR>à {{$voucher->dateFirst->formatLocalized('%R')}}</small></td>
                    <td><small class='text-center'>{{$voucher->dateLast->formatLocalized('%e %B %Y')}}<BR>à {{$voucher->dateLast->formatLocalized('%R')}}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection