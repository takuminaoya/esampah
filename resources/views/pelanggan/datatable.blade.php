@if (auth()->user()->level == 'admin' || auth()->user()->level == 'bendahara')
<div class="table-responsive">
    <table id="datatable1" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Nama Usaha</th>
                <th>Banjar</th>
                <th>Group</th>
                <th>Mulai Langganan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelanggans as $pelanggan)
            <tr>
                <td>{{  $pelanggan->kode_pelanggan  }}</td>
                <td>{{  $pelanggan->nama  }}</td>
                <td>{{ $pelanggan->usaha }}</td>
                <td>{{  ($pelanggan->banjar)? $pelanggan->banjar->nama : '' }}</td>
                <td>{{  getJalur($pelanggan->id)  }}</td>
                <td>{{ Carbon\Carbon::parse($pelanggan->tgl_verified)->format('d-m-Y') }}</td>
                <td>
                    @if($pelanggan->status == true)
                    <button type="button" class="btn btn-success btn-style-light" data-bs-toggle="modal" data-bs-target="#editStatus_{{$pelanggan->id}}">
                        Aktif
                    </button>
                    @else
                    <button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#editStatus_{{$pelanggan->id}}">
                        Nonaktif
                    </button>
                    @endif
                    <div class="modal fade" id="editStatus_{{$pelanggan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ ($pelanggan->status == true)? 'Nonaktifkan Status Pelanggan' : 'Aktifkan Status Pelanggan' }}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="{{ route('pelanggan.updateStatus',$pelanggan->id) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                            <div class="form-group"> 
                                                <p>Apakah Anda yakin untuk {{ ($pelanggan->status == true)? 'mengnonaktifkan' : 'mengaktifkan' }} pelanggan ini?</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary" >Ya </button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
               <td>
                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $pelanggan->id }}">
                    <i class="material-icons">info</i> Detail
                 </button>
                <a href="{{ route('pelanggan.edit',$pelanggan->id) }}" class="btn btn-outline-warning btn-sm">
                    <i class="material-icons">edit</i> Edit
                 </a>
                 <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus{{ $pelanggan->id }}">
                    <i class="material-icons">delete</i> Hapus
                 </button>
                <div class="modal fade" id="detail{{ $pelanggan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detail Pelanggan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <table class="col-sm-12 col-lg-6">
                                        <tbody>
                                            <tr>
                                                <td>Nama</td>
                                                <td>: {{  $pelanggan->nama  }}</td>
                                            </tr>
                                            <tr>
                                                <td>NIK</td>
                                                <td>: {{  $pelanggan->nik  }}</td>
                                            </tr>
                                            <tr>
                                                <td>Banjar</td>
                                                <td>: {{  ($pelanggan->banjar)? $pelanggan->banjar->nama : ''  }}</td>
                                            </tr>
                                            <tr>
                                                <td>Telp</td>
                                                <td>: {{ $pelanggan->telp }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Daftar</td>
                                                <td>: {{ $pelanggan->created_at->format('d-m-Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="col-sm-12 col-lg-6">
                                        <tbody>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>: {{  $pelanggan->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>: {{ $pelanggan->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Kategori</td>
                                                <td>: {{ ($pelanggan->kodeDistribusi)? $pelanggan->kodeDistribusi->objek : '' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Usaha</td>
                                                <td>: {{  $pelanggan->usaha }}</td>
                                            </tr>
                                            <tr>
                                                <td>Iuran</td>
                                                <td>: {{ number_format($pelanggan->biaya,0) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="hapus{{$pelanggan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Hapus Pelanggan</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('pelanggan.delete',$pelanggan->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                        <div class="form-group"> 
                                            <p>Apakah Anda yakin untuk menghapus data pelanggan ini?</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" >Ya </button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
               </td>
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
</div>
@endif