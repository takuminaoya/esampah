<div class="app-menu">
    <div class="container">
        <ul class="menu-list">
            <li class="active-page">
                <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            </li>
            @if (auth()->user()->level == 'petugas')
                <li>
                    <a href="#">Jadwal<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('pengambilan.getJadwal') }}">Pengambilan</a>
                        </li>
                        <li>
                            <a href="{{ route('pembayaran.getJadwal') }}">Pembayaran</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->level == 'bendahara')
            <li>
                <a href="#">Kelola<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
                    </li>
                    <li>
                        <a href="{{ route('pembayaran.index') }}">Pembayaran</a>
                    </li>
                    <li>
                        <a href="{{ route('pendapatan.index') }}">Pendapatan</a>
                    </li>
                    <li>
                        <a href="{{ route('pembuangan.index') }}">Rekap Pembuangan</a>
                    </li>
                </ul>
            </li>
            @endif
            @if (auth()->user()->level == 'admin')
            <li>
                <a href="#">Kelola<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('jalur.index') }}">Jalur</a>
                    </li>
                    <li>
                        <a href="{{ route('kode-distribusi.index') }}">Kode Distribusi</a>
                    </li>
                    <li>
                        <a href="{{ route('rekanan.index') }}">Rekanan</a>
                    </li>
                    <li>
                        <a href="{{ route('pelanggan.index') }}">Pelanggan</a>
                    </li>
                    <li>
                        <a href="{{ route('petugas.index') }}">Petugas</a>
                    </li>
                    <li>
                        <a href="{{ route('pembayaran.index') }}">Pembayaran</a>
                    </li>
                </ul>
            </li>
            @endif
            <li>
                @if (auth()->user()->level == false || auth()->user()->level == 'petugas' )
                <a href="#">Riwayat<i class="material-icons has-sub-menu">keyboard_arrow_down</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('pengambilan.index') }}">Pengambilan</a>
                    </li>
                    <li>
                        <a href="{{ route('pembayaran.index') }}">Pembayaran</a>
                    </li>
                    @if (auth()->user()->level == 'petugas' )
                    <li>
                        <a href="{{ route('setoran.index') }}">Setoran</a>
                    </li>
                    @endif
                   
                </ul> @endif
            </li>
        </ul>
    </div>
</div>