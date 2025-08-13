<div class="row jadwal">
    <div class="col-lg-4 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('pembayaran.getJadwal') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-primary">
                        <i class="material-icons-outlined">paid</i>
                    </div>
        
                    @if (auth()->user()->level == 'petugas')
                        <div class="widget-stats-content flex-fill">
                            <span class="widget-stats-title">Jadwal Hari Ini</span>
                            <span class="widget-stats-amount">{{ $pembayaran }}</span>
                            <span class="widget-stats-info">Pelanggan </span>
                        </div>
                    @endif
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('pengambilan.getJadwal') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Sisa Pengambilan Hari Ini</span>
                        <span class="widget-stats-amount">{{ $pengambilan }}</span>
                        <span class="widget-stats-info">Rumah </span>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('setoran.index') }}">
            <div class="card-body">
                <div class="widget-stats-container d-flex">
                    <div class="widget-stats-icon widget-stats-icon-warning">
                        <i class="material-icons-outlined">person</i>
                    </div>
                    <div class="widget-stats-content flex-fill">
                        <span class="widget-stats-title">Total Uang Belum Disetor</span>
                        <span class="widget-stats-amount">Rp {{ number_format($setoran,0) }}</span>
                        <span class="widget-stats-info">Jan - {{ Carbon\Carbon::today()->format('F Y') }}</span>
                    </div>
                    
                </div>
            </div>
            </a>
        </div>
    </div>
    @if($pengambilan_terakhir !== null)
        <strong class="mb-3">Pengambilan Terakhir Anda</strong>
        <div class="col-12">
            <div class="card widget widget-popular-blog">
                <div class="card-body">
                    <div class="widget-popular-blog-container">
                        <div class="widget-popular-blog-image">
                            <img src="../storage/{{ $pengambilan_terakhir->gambar }}" alt=""> 
                        </div>
                        <div class="widget-popular-blog-content ps-4">
                            <span class="widget-popular-blog-title">
                                Rumah {{ $pengambilan_terakhir->user->nama }}
                            </span>
                            <span class="widget-popular-blog-text"> Sampah
                                @if ($pengambilan_terakhir->status == "0")
                                    belum diambil
                                @elseif ($pengambilan_terakhir->status == "1")
                                    sudah diambil
                                @else 
                                    tidak diambil dengan alasan : {{ $pengambilan_terakhir->alasan }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="widget-popular-blog-date">
                        Waktu: {{ $pengambilan_terakhir->updated_at->format('h:i A') }}
                    </span>
                    <a href="{{ route('pengambilan.index') }}" class="btn btn-primary btn-style-light float-end">Selengkapnya</a>
                </div>
            </div>
        </div>
    @endif
</div>