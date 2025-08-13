<div class="row jadwal">
    <div class="col-lg-3 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('verifikasi.getVerifikasiPelanggan') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-primary">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Belum Terverifikasi</span>
                        <span class="widget-stats-amount">{{ $unverified }}</span>
                        <span class="widget-stats-info">Orang/Badan Usaha</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('pelanggan.index') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Jumlah Pelanggan</span>
                        <span class="widget-stats-amount">{{ $pelanggans }}</span>
                        <span class="widget-stats-info">Orang/Badan Usaha</span>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('verifikasi.getNonaktif') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Pelanggan Nonaktif </span>
                        <span class="widget-stats-amount">{{ $nonaktifs }}</span>
                        <span class="widget-stats-info">Orang/Badan Usaha</span>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('verifikasi.getKadaluarsa') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Jumlah Akun Kadaluarsa</span>
                        <span class="widget-stats-amount">{{ $overdue }}</span>
                        <span class="widget-stats-info">Orang/Badan Usaha</span>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Jumlah Pelanggan</h4>
                <canvas id="singelBarChart" ></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Status Pelanggan</h4>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rekapitulasi Pelanggan Sampah</h4>
                <canvas id="sales-chart" width="500" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@push('scripts')
<script src="{{ asset('plugins/chartjs/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('plugins-init/chartjs-init.js') }}"></script>

<script>

// single bar chart
$.get("{{ route('getSingleChartPelanggan') }}",function([banjars,data_pelanggans]){
    var ctx = document.getElementById("singelBarChart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: banjars,
            datasets: [
                {
                    label: "Jumlah Pelanggan",
                    data: data_pelanggans,
                    borderColor: "rgba(117, 113, 249, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(117, 113, 249, 0.5)"
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});



//pie chart
$.get("{{ route('getDonutChartPelanggan') }}",function(jumlah){
var ctx = document.getElementById("pieChart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: jumlah,
                backgroundColor: [
                    "rgba(117, 113, 249,0.9)",
                    "rgba(117, 113, 249,0.7)",
                    "rgba(117, 113, 249,0.5)",
                    "rgba(144,	104,	190,0.7)"
                ],
                hoverBackgroundColor: [
                    "rgba(117, 113, 249,0.9)",
                    "rgba(117, 113, 249,0.7)",
                    "rgba(117, 113, 249,0.5)",
                    "rgba(144,	104,	190,0.7)"
                ]

            }],
            labels: [
                "Aktif",
                "Nonaktif",
            ]
        },
        options: {
            responsive: true
        }
    });
});

    //Sales chart
$.get("{{ route('getSalesChartPelanggan') }}",function([aktifs,nonaktifs,totals]){
    var ctx = document.getElementById("sales-chart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul","Aug","Sep","Okt","Nov","Dec"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [{
                label: "Aktif",
                data: aktifs,
                backgroundColor: 'transparent',
                borderColor: '#7571F9',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#7571F9',

            }, {
                label: "Nonaktif",
                data: nonaktifs,
                backgroundColor: 'transparent',
                borderColor: '#4d7cff',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#4d7cff',
            }, {
                label: "Jumlah",
                data: totals,
                backgroundColor: 'transparent',
                borderColor: '#173e43',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#173e43',
            }]
        },
        options: {
            responsive: true,

            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });
});

</script>
@endpush
