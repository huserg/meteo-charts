<div style="max-height: 300px !important;"
     wire:key="{{ $chartId }}"
     x-data="{ chart: null, chartId: @js($chartId), labels: @js($labels), datasets: @js($dataset), name: @js($name) }"
     x-init="
      let chartExist = Chart.getChart(chartId);
        if (chartExist !== undefined)
            chartExist.destroy();

    chart = new Chart(document.getElementById(chartId).getContext('2d'), {
         type: 'line',
         data: {
             labels: labels,
             datasets: datasets
         },
         options: {
            responsive: true,
            interaction: {
              mode: 'index',
              intersect: false
            },
            aspectRatio: 2,
            scales: {
              x: {
                type: 'time',
                time: {
                  unit: 'day',
                  parser: 'yyyy-MM-dd HH:mm:ss',
                  tooltipFormat: 'EEEE dd MMMM yyyy - HH:mm',
                  displayFormats: {
                    day: 'EEE, d.M.yy'
                  }
                },
                title: {
                  display: false,
                  text: 'Date'
                }
              },
              y: {
                title: {
                  display: false,
                  text: name
                }
              }
            },
            plugins: {
              title: {
                display: false,
                text: name
              }
            }
          }
      });
      ">
    <canvas id="{{ $chartId }}" height="300"></canvas>
</div>
