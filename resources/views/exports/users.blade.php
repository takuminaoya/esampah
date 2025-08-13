<table id="datatable1" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Nama Usaha</th>
            <th>Banjar</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Kode</th>
            <th>Group</th>
            <th>Mulai Langganan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
        <tr>
            <td>{{  $user->kode_user  }}</td>
            <td>{{  $user->nama  }}</td>
            <td>{{ $user->usaha }}</td>
            <td>{{  ($user->banjar)? $user->banjar->nama : '' }}</td>
            <td>{{ $user->telp }}</td>
            <td>: {{ $user->alamat }}</td>
            <td>: {{ $user->kodeDistribusi->kode }}</td>
            <td>{{  getJalur($user->id)  }}</td>
            <td>{{ Carbon\Carbon::parse($user->tgl_verified)->format('d-m-Y') }}</td>
            <td>{{ $user->status }}</td>
        </tr>
        @empty
            <tr>
                <td colspan="20" class="text-center">
                    <p>Tidak ada data</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>