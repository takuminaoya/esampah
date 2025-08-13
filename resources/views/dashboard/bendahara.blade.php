<div class="row jadwal">
    <div class="col-lg-6 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('verifikasi.getVerifikasiTransfer') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-primary">
                        <i class="material-icons-outlined">paid</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Pembayaran Transfer</span>
                        <span class="widget-stats-amount">{{ $transfer }}</span>
                        <span class="widget-stats-info">Belum Diverifikasi</span>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('verifikasi.getVerifikasiSetoran') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Total Uang Belum Disetor</span>
                        <span class="widget-stats-amount">Rp {{ ($belum_setor !== null)? number_format($belum_setor,0) : '0'  }}</span>
                        <span class="widget-stats-info">oleh petugas</span>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
    </div>
    {{-- <div class="col-lg-6 col-sm-12">
        <div class="card widget widget-stats">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Pendapatan Bulan Ini</span>
                        <span class="widget-stats-amount">Rp {{ ($pend_bulan !== null)? number_format($pend_bulan,0) : '0'  }}</span>
                        <span class="widget-stats-info">{{ Carbon\Carbon::today()->isoFormat('MMMM YYYY') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="card widget widget-stats">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Pendapatan Tahun Ini</span>
                        <span class="widget-stats-amount">Rp {{ ($pend_tahun !== null)? number_format($pend_tahun,0) : '0'  }}</span>
                        <span class="widget-stats-info">Jan-{{ Carbon\Carbon::today()->isoFormat('MMMM YYYY') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Column Chart</h5>
            </div>
            <div class="card-body">
                <div id="apex3"></div>
            </div>
        </div>
    </div> --}}
    @if($verifikasi_akhir !== null)
        <strong class="mb-3">Pembayaran Terakhir Yang Anda Verifikasi</strong>
        <div class="col-12">
            <div class="card widget widget-popular-blog">
                <div class="card-body">
                    <div class="widget-popular-blog-container">
                        @if($verifikasi_akhir->isTransfer == true)
                            <div class="widget-popular-blog-image">
                                <img src="../storage/{{ $verifikasi_akhir->bukti_bayar }}" alt=""> 
                            </div>
                        @endif
                        <div class="widget-popular-blog-content ps-4">
                            <span class="widget-popular-blog-title">{{ $verifikasi_akhir->user->nama }}</span>
                            <span class="widget-popular-blog-text">
                                Pembayaran Bulan :
                                @foreach ($verifikasi_akhir->detailPembayaran as $detail) 
                                    {{ Carbon\Carbon::parse($detail->bulan_bayar)->isoFormat('MMMM Y') }},
                                @endforeach
                                <br>
                                Tanggal : {{ $verifikasi_akhir->created_at->format('d-m-Y') }}
                                <br>
                                <b> Total Bayar : Rp. {{ number_format($verifikasi_akhir->total,0) }}</b>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="widget-popular-blog-date">
                        Waktu: {{ $verifikasi_akhir->updated_at->format('h:i A') }}
                    </span>
                </div>
            </div>
        </div>
    @endif

</div>