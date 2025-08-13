@if (auth()->user()->level == false)
    <table id="datatable1" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Petugas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengambilans as $pengambilan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengambilan->created_at->isoFormat('dddd, D MMMM Y')}}</td>
                @if ($pengambilan->status == "0")
                    <td>Belum diambil</td>
                @elseif ($pengambilan->status == "1")
                    <td>Sudah diambil</td>
                @else 
                    <td>Tidak diambil</td>
                @endif
                <td>{{ $pengambilan->pegawai->nama }}</td>
                @if($pengambilan->alasan == null) 
                    <td>-</td>
                @else
                <td>{{ $pengambilan->alasan }}</td> 
                @endif
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
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Banjar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengambilans as $pengambilan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengambilan->created_at->isoFormat('dddd, D MMMM Y')}}</td>
                <td>{{ $pengambilan->user->nama }}</td>
                <td>{{ $pengambilan->user->banjar->nama }}</td>
                @if ($pengambilan->status == "0")
                    <td>Belum diambil</td>
                @elseif ($pengambilan->status == "1")
                    <td>Sudah diambil</td>
                @else 
                    <td>Tidak diambil</td>
                @endif
                @if($pengambilan->alasan == null) 
                    <td>-</td>
                @else
                    <td>{{ $pengambilan->alasan }}</td> 
                @endif
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

@elseif (auth()->user()->level == 'bendahara')

@elseif (auth()->user()->level == 'admin')

@endif
                
            

