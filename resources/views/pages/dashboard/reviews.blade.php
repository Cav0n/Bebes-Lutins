@extends('templates.dashboard')

@section('content')
<div class="card bg-white my-3">
    <div class="card-header bg-white">
        <h1 class='h4 m-0 font-weight-normal'>
            Clients - Avis
        </h1>
    </div>
    <div class="card-body">
        
        @include('components.dashboard.search-bar')

        {{$reviews->links()}}        
        <table class="table" style='table-layout:fixed'>
            <thead>
                <tr>
                    <th class='border-top-0 text-center'>Date</th>
                    <th class='border-top-0'>Client</th>
                    <th class='border-top-0'>Produit</th>
                    <th class='border-top-0 text-center'>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                <tr onclick='load_url("/dashboard/clients/avis/{{$review->id}}")'>
                    <td scope="row" class='small align-middle text-center'>{{$review->created_at->formatLocalized('%e %B %Y')}}<BR>à {{$review->created_at->formatLocalized('%R')}}</td>
                    <td class='align-middle'>{{$review->customerPublicName}}</td>
                    <td class='small align-middle'>{{$review->product->name}}</td>
                    <td class='text-center align-middle'>{{$review->mark}} / 5</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection