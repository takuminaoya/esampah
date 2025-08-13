<div class="row jadwal">
    <div class="col-lg-6 col-sm-12">
        <div class="card widget widget-stats">
            <a href="{{ route('pembayaran.getTransfer') }}">
                <div class="card-body">
                    <div class="widget-stats-container d-flex">
                        <div class="widget-stats-icon widget-stats-icon-primary">
                            <i class="material-icons-outlined">paid</i>
                        </div>
                        
                            <div class="widget-stats-content flex-fill">
                                <span class="widget-stats-title">Tenggat Pembayaran</span>
                                <span class="widget-stats-amount">{{ $tgl_tenggat }}</span>
                                <span class="widget-stats-info">Pembayaran Bulan {{ Carbon\Carbon::today()->isoFormat('MMMM') }}</span>
                            </div>
                            @if(getStatusBayar(Auth::id()) == false)
                            <div class="widget-stats-indicator widget-stats-indicator-negative align-self-start">
                                Belum Lunas
                            </div>
                            @else
                            <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                Lunas
                            </div>
                            @endif
                    </div>
                </div>
            </a>
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
                        
                            <span class="widget-stats-title">Pengambilan Hari Ini</span>
                            @if($pengambilan_terakhir !== null)
                                @if($pengambilan_terakhir->created_at == Carbon\Carbon::today())
                                    @if($pengambilan_hari_ini->status == "1")
                                        <span class="widget-stats-amount">Sudah Diambil</span>
                                    @else
                                        <span class="widget-stats-amount">Tidak Diambil </span>
                                    @endif
                                    <span class="widget-stats-info">oleh {{ $pengambilan_hari_ini->pegawai->nama }} </span>
                                @else
                                    <span class="widget-stats-amount">Belum Diambil</span>
                                    <span class="widget-stats-info">oleh -</span>
                                @endif
                            @else
                                <span class="widget-stats-amount">Belum Diambil</span>
                                <span class="widget-stats-info">oleh -</span>
                            @endif
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    @if($pengambilan_terakhir !== null)
        <strong class="mb-2">Pengambilan Terakhir</strong>
        <div class="col-12">
            <div class="card widget widget-popular-blog">
                <div class="card-body">
                    <div class="widget-popular-blog-container">
                        <div class="widget-popular-blog-image">
                            <img src="../storage/{{ $pengambilan_terakhir->gambar }}" alt=""> 
                        </div>
                        <div class="widget-popular-blog-content ps-4">
                            <span class="widget-popular-blog-title">
                                {{$pengambilan_terakhir->created_at->isoFormat('dddd, D MMMM Y')}}
                            </span>
                            <span class="widget-popular-blog-text"> Sampah
                                @if ($pengambilan_terakhir->status == "0")
                                    belum diambil
                                @elseif ($pengambilan_terakhir->status == "1")
                                    sudah diambil oleh {{ $pengambilan_terakhir->pegawai->nama }} 
                                @else 
                                    tidak diambil oleh {{ $pengambilan_terakhir->pegawai->nama }} dengan alasan : {{ $pengambilan_terakhir->alasan }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="widget-popular-blog-date">
                        Waktu: {{ $pengambilan_terakhir->created_at->format('h:i A') }}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>