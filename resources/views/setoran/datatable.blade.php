
    @if (auth()->user()->level == 'petugas')
        <table id="datatable1" class="display" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Pelanggan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Tanggal Bayar</th>
                    <th scope="col">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setorans as $setoran)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td scope="row">{{ $setoran->user->nama }}</td>
                    <td scope="row">{{ $setoran->user->alamat }}</td>
                    <td scope="row">{{ $setoran->created_at->format('d/m/Y') }}</td>
                    <td scope="row">{{ number_format($setoran->total,0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @elseif (auth()->user()->level == 'bendahara')
        <table id="datatable1" class="display" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Bulan</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setorans as $setoran)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td scope="row">1/{{$setoran->month}}/{{ Carbon\Carbon::today()->year }}</td>
                    <td scope="row">Setoran ke bendahara</td>
                    <td scope="row">{{ number_format($setoran->biaya,0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif