@extends('templates.admin')

@section('content')


<div class="row">
    <div class="col-12 col-sm-6 col-lg-4 px-3 px-lg-1 mb-2 order-2 order-lg-1">
        <div class="chart-container bg-white shadow-sm p-2">
            <div class="title ml-3 mb-2">
                <h4 class="mb-0">{{ $analytics['total']['orders'] }}</h4>
                <p class="mb-0 small uppercase">commandes</p>
            </div>
            <canvas id="orderCount" width="400" height="200"></canvas>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-4 px-3 px-lg-1 mb-2 order-3 order-lg-2">
        <div class="chart-container bg-white shadow-sm p-2">
            <div class="title ml-3 mb-2">
                <h4 class="mb-0">{{ $analytics['total']['ordersCost'] }} €</h4>
                <p class="mb-0 small uppercase">de commandes</p>
            </div>
            <canvas id="orderCosts" width="400" height="200"></canvas>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-4 px-3 px-lg-1 mb-2 order-4 order-lg-3">
        <div class="chart-container bg-white shadow-sm p-2">
            <div class="title ml-3 mb-2">
                <h4 class="mb-0">{{ $analytics['total']['customers'] }}</h4>
                <p class="mb-0 small uppercase">nouveaux clients</p>
            </div>
            <canvas id="newCustomersCount" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="col-12 col-lg-6 px-3 px-lg-1 mb-2 order-1 order-lg-4">
        <div class="bg-white shadow-sm p-3">
            <p class="mb-0">
                Bienvenue dans le nouveau Dashboard, {{ Session::get('admin')->firstname }} {{ Session::get('admin')->lastname }} ! <br>
                Vous pouvez retrouvez la liste des nouveautés <a href="#">ici</a>.
            </p>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-6 px-3 px-lg-1 order-5">
        <div class="chart-container p-2">
            <div class="title ml-3 mb-2 text-center">
                <h4 class="mb-0">Civilité des clients</h4>
            </div>
            <canvas id="civilitiesCount" width="400" height="150"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var canvaOrders = document.getElementById('orderCount').getContext('2d');
    $(document).ready(function() {
        var ordersChart = new Chart(canvaOrders, {
        type: 'line',
        data: {
            labels: [ @foreach($analytics['orders'] as $analytic) "{{ $analytic['date'] }}", @endforeach ],
            datasets: [{
                label: 'Nombre de commandes',
                data: [ @foreach($analytics['orders'] as $analytic) {{ $analytic['value'] }}, @endforeach ],
                fill: false,
                borderColor: '#9561e2'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
        });
        console.log('orders chart ok');
    });
</script>

<script>
    var canvaOrdersCosts = document.getElementById('orderCosts').getContext('2d');
    $(document).ready(function() {
        var ordersChart = new Chart(canvaOrdersCosts, {
        type: 'line',
        data: {
            labels: [ @foreach($analytics['ordersCost'] as $analytic) "{{ $analytic['date'] }}", @endforeach ],
            datasets: [{
                label: 'Total de vente',
                data: [ @foreach($analytics['ordersCost'] as $analytic) {{ $analytic['value'] }}, @endforeach ],
                fill: false,
                borderColor: '#9561e2'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return value + ' €';
                        }
                    }
                }]
            },
            legend: {
                display: false,
            }
        }});
        console.log('orders costs chart ok');
    });
</script>

<script>
    var canvaCustomers = document.getElementById('newCustomersCount').getContext('2d');
    $(document).ready(function() {
        var customersChart = new Chart(canvaCustomers, {
        type: 'line',
        data: {
            labels: [ @foreach($analytics['customers'] as $analytic) "{{ $analytic['date'] }}", @endforeach ],
            datasets: [{
                label: 'Nombre de nouveaux clients',
                data: [ @foreach($analytics['customers'] as $analytic) {{ $analytic['value'] }}, @endforeach ],
                fill: false,
                borderColor: '#9561e2'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
        });
        console.log('customers chart ok');
    });
</script>

<script>
    var civilitiesCountCanva = document.getElementById('civilitiesCount').getContext('2d');

    var civilitiesCount = new Chart(civilitiesCountCanva, {
        type: 'doughnut',
        data: {
            labels: [ 'Monsieur', 'Madame' ],
            datasets: [{
                label: 'Nombre de nouveaux clients',
                data: [ {{ $analytics['total']['civility']['mister'] }}, {{ $analytics['total']['civility']['miss'] }} ],
                backgroundColor: [ '#36a2eb', '#ff6384' ]
            }]
        },
        options: {
            legend: {
                display: false,
            }
        }
    });
</script>

@endsection
