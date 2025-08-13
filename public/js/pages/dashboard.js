$(document).ready(function () {

  "use strict";
  var options1 = {
    chart: {
        height: 350,
        type: 'bar',
        toolbar: {
          show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
            borderRadius: 10
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    series: [{
        name: 'Siswa',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
    }],
    xaxis: {
        title: {
            text: 'Umur (Tahun)'
        },
        categories: [8, 9, 10, 11, 12, 13, 14, 15, 16],
        labels: {
            style: {
                colors: 'rgba(94, 96, 110, .5)'
            }
        }
    },
    yaxis: {
        title: {
            text: 'Jumlah Siswa'
        }
    },
    fill: {
        opacity: 1

    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val + " thousands"
            }
        }
    },
    grid: {
        borderColor: '#e2e6e9',
        strokeDashArray: 4
    }
}
  var chart1 = new ApexCharts(
    document.querySelector("#apex-earnings"),
    options1
  );

  chart1.render();
});