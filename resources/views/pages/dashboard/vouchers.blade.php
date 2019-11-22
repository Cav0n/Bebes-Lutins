@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white d-flex">
        <h1 class='h4 m-0 font-weight-normal'>
            Réductions
        </h1>
        <a name="btn-creation" id="btn-creation" class="btn btn-primary border-light ml-auto" href="/dashboard/reductions/nouveau" role="button">Nouveau</a>
    </div>
    <div class="card-body">

        @include('components.dashboard.search-bar')

        {{$vouchers->links()}}        
        <table class="table">
            <thead>
                <tr>
                    <th class='border-top-0'>Code</th>
                    <th class='border-top-0'>Réduction</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $voucher)
                <tr onclick='load_url("/dashboard/reductions/edition/{{$voucher->id}}")' class='@if(Carbon\Carbon::now() > $voucher->dateLast) text-danger @endif @if(Carbon\Carbon::now() < $voucher->dateFirst) text-muted @endif'>
                    <td scope="row" class='font-weight-bold'>
                        {{$voucher->code}}
                        @if(Carbon\Carbon::now() > $voucher->dateLast) <span class="badge badge-danger">Éxpiré</span> @endif
                        @if(Carbon\Carbon::now() < $voucher->dateFirst) <span class="badge badge-warning">Programmé</span> @endif                        
                    </td>
                    <td>{{$voucher->discountValue}} {{$voucher->typeToString()}}</td>
                    <td><small class='text-center'>{{$voucher->dateFirst->formatLocalized('%e %B %Y')}}<BR>à {{$voucher->dateFirst->formatLocalized('%R')}}</small></td>
                    <td><small class='text-center'>{{$voucher->dateLast->formatLocalized('%e %B %Y')}}<BR>à {{$voucher->dateLast->formatLocalized('%R')}}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection