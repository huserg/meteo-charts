<div style="max-height: 300px !important;"
    x-data="{ chart: null, chartId: @js($chartId) }"
     x-init="chart = new Chart(document.getElementById(chartId).getContext('2d'), {
         type: 'line',
         data: {
             labels: $wire.labels,
             datasets: $wire.dataset,
         },
         options: {
            responsive: true,
            interaction: {
              mode: 'index',
              intersect: false,
            },
            aspectRatio: 2,
            stacked: false,
            plugins: {
              title: {
                display: false,
                text: $wire.name
              }
            },
          },
      });
      ">
    <canvas id="{{ $chartId }}" height="300"></canvas>
</div>
