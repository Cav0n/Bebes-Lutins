<div class="chart-container bg-white shadow-sm p-2">
    <div class="title ml-3 mb-2">
        <h4 class="mb-0 {{ $chartName ?? 'chart' }}"></h4>
        <p class="mb-0 small uppercase {{ $chartName ?? 'chart' }}"></p>
    </div>
    <canvas
    id="{{ $chartName ?? 'chart' }}"
    width="{{ $chartWidth ?? 400 }}"
    height="{{ $chartHeight ?? 200 }}"></canvas>
</div>
