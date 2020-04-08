@extends('templates.admin')

@section('content')


<div class="row px-lg-3">
    <div class="col-12 col-sm-6 col-lg-4 px-3 px-lg-1 mb-2 order-2 order-lg-1">
        @include('components.utils.charts.canva', ['chartName' => 'sales'])
    </div>
    <div class="col-12 col-sm-6 col-lg-4 px-3 px-lg-1 mb-2 order-3 order-lg-2">
        @include('components.utils.charts.canva', ['chartName' => 'orderCount'])
    </div>
    <div class="col-12 col-sm-6 col-lg-4 px-3 px-lg-1 mb-2 order-4 order-lg-3">
        @include('components.utils.charts.canva', ['chartName' => 'newCustomersCount'])
    </div>
    <div class="col-12 col-lg-6 px-3 px-lg-1 mb-2 order-1 order-lg-5">
        <div class="bg-white shadow-sm p-3">
            <p class="mb-0">
                Bienvenue dans le nouveau Dashboard, {{ Session::get('admin')->firstname }} {{ Session::get('admin')->lastname }} ! <br>
                Vous pouvez retrouvez la liste des nouveautés <a href="{{ route('admin.changelog') }}">ici</a>.
            </p>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    let firstDate = moment().subtract(30, 'days').format('DD/MM/YYYY');
    let lastDate = moment().format('DD/MM/YYYY');

    $(document).ready(function(){
        generateChart("{{ route('api.analytics.count') }}", 'order', 'orderCount', 'Nombre de commandes', firstDate, lastDate);
        generateChart("{{ route('api.analytics.count') }}", 'user', 'newCustomersCount', 'Nombre de nouveaux clients', firstDate, lastDate);
        generateChart("{{ route('api.analytics.sales') }}", 'order', 'sales', 'Total de ventes', firstDate, lastDate, '1 day', ' €');
    });
</script>

@include('components.utils.charts.js')
@endsection
