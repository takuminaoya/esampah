<table id="datatable1" class="display" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Banjar</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Telp</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($petugass as $petugas)
            <tr>
                <td>{{  $loop->iteration  }}</td>
                <td>{{  $petugas->nama  }}</td>
                <td>{{  $petugas->banjar->nama  }}</td>
                <td>{{  $petugas->alamat }}</td>
                <td>{{ $petugas->email }}</td>
                <td>{{ $petugas->telp }}</td>
                {{-- <td>
                    @if($petugas->status == true)
                    <button type="button" class="btn btn-success btn-style-light" data-bs-toggle="modal" data-bs-target="#editStatus_{{$petugas->id}}">
                        Aktif
                    </button>
                    @else
                    <button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#editStatus_{{$petugas->id}}">
                        Nonaktif
                    </button>
                    @endif

                    <div class="modal fade" id="editStatus_{{$petugas->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ ($petugas->status == true)? 'Nonaktifkan Status Petugas' : 'Aktifkan Status Petugas' }}</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="{{ route('petugas.updateStatus',$petugas->id) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                            <div class="form-group"> 
                                                <p>Apakah Anda yakin untuk {{ ($petugas->status == true)? 'mengnonaktifkan' : 'mengaktifkan' }} petugas ini?</p>
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
                </td> --}}
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