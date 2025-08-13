@if (auth()->user()->level == 'admin')
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Rekanan</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Jumlah Pelanggan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekanans as $rekanan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rekanan->nama }}</td>
                    <td>{{ $rekanan->email }}</td>
                    <td>{{ $rekanan->telp }}</td>
                    <td>{{ getJumlahPelangganRekanan($rekanan->id)}}</td>
                    <td><a href="{{ route('rekanan.detail',$rekanan->id) }}" class="btn btn-primary">Detail</a></td>
                </tr>
                @empty
                <tr>
                     <td>tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
@endif
                
            

