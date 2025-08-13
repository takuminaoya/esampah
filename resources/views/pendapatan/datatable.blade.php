@if (auth()->user()->level == 'bendahara')
    <table id="datatable1" class="display" style="width:100%">
        <thead>
            <tr class="align-middle">
                <th>No.</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jenis</th>
                <th>Bulan</th>
                <th>Jenis Bayar</th>
                <th>Jumlah (Rp)</th>
                <th>Aksi</th>
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
                    <td><button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#hapus_{{$pendapatan->id}}">
                        Hapus
                        </button>
                        <div class="modal fade" id="hapus_{{$pendapatan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus pendapatan</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="{{ route('pendapatan.destroy',$pendapatan->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                                <div class="form-group"> 
                                                    <p>Apakah Anda yakin untuk memhapus pendapatan ini?</p>
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
                    <td colspan="10" class="text-center">
                        <p>Tidak ada data</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endif
                
            

