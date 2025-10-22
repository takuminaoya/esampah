<table id="" class="table display" style="width:100%">
    <thead>
        <tr class="align-middle">
            <th>No.</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Jenis</th>
            <th>Bulan</th>
            <th>Jenis Bayar</th>
            <th>Jumlah (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pendapatans as $pendapatan)
            <tr>
                <td>{{  $loop->iteration  }}</td>
                <td>{{ $pendapatan->created_at->format('d/m/Y') }}</td>
                <td>{{  $pendapatan->keterangan }}</td> 
                <td>{{ ($pendapatan->jenis_pendapatan_id !== null)? $pendapatan->jenisPendapatan->nama : '-' }}</td>
                <td>{{ Carbon\Carbon::parse($pendapatan->bulan_bayar)->format('F') }}</td>
                <td>{{ ($pendapatan->isTransfer == 1)? 'Transfer' : 'Cash' }}</td>
                <td>{{ number_format($pendapatan->jumlah) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center">
                    <p>Tidak ada data</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>