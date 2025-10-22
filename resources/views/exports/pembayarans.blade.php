<table  class="table display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            @foreach(getMonthsYear() as $month)
                <th>{{ $month }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($pembayarans as $pembayaran)
        <tr>
            <td>{{  $pembayaran->kode_pelanggan  }}</td>
            <td>{{  $pembayaran->nama  }}</td>
            @foreach(getMonthsYear() as $month)
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