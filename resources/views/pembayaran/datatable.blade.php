@if (auth()->user()->level == false)
    <table id="datatable1" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Bulan</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
                <th>Penerima</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembayarans as $pembayaran)
                <tr>
                    <td>{{  $loop->iteration  }}</td>
                    <td>{{ Carbon\Carbon::parse($pembayaran->bulan_bayar)->isoFormat('MMMM Y') }}</td>
                    <td>{{ ($pembayaran->pembayaran->verifikasi_bendahara == 1)? 'Lunas' : 'Belum diverifikasi CUB' }}</td>
                    <td>{{ $pembayaran->pembayaran->created_at->isoFormat('D MMMM Y') }}</td>
                    <td>{{ ($pembayaran->pembayaran->pegawai_id == null)? 'Admin' : $pembayaran->pembayaran->pegawai->nama }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <p>Tidak ada data</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@elseif (auth()->user()->level == 'petugas')
    <table id="datatable1" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Nama Usaha</th>
                <th>Banjar</th>
                <th>Tanggal Bayar</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembayarans as $pembayaran)
            <tr>
                <td>{{  $loop->iteration  }}</td>
                <td>{{  $pembayaran->user->nama  }}</td>
                <td>{{  $pembayaran->user->usaha  }}</td>
                <td>{{  $pembayaran->user->banjar->nama  }}</td>
                <td>{{ $pembayaran->created_at->format('d-m-Y') }}</td>
                <td>{{ number_format($pembayaran->total,0) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <p>Tidak ada data</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@elseif (auth()->user()->level == 'bendahara' || auth()->user()->level == 'admin')
<div class="table-responsive">
    <table id="datatable1" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                @foreach($months as $month)
                    <th>{{ $month }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($pembayarans as $pembayaran)
            <tr>
                <td>{{  $pembayaran->kode_pelanggan  }}</td>
                <td>{{  $pembayaran->nama  }}</td>
                @foreach($months as $month)
                @foreach (getDetailPembayaran($pembayaran->id) as $bulan => $detail)
                    @if($bulan == Carbon\Carbon::parse($month)->format('F'))
                        <td>{{ number_format($detail,0) }}</td>
                    @endif
                @endforeach
            @endforeach
            </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <p>Tidak ada data</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="table-responsive">
@endif
                    