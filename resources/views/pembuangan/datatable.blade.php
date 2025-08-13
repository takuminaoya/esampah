@if (auth()->user()->level == 'bendahara')
        <table class="table table-responsive">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Plat Armada</th>
                    <th>Jumlah</th>
                    <th>Rekanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($rekanans as $rekanan) --}}
                @foreach ($pembuangans as $pembuangan)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Carbon\Carbon::parse($pembuangan->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $pembuangan->kendaraan->plat }}</td>
                    <td>{{ $pembuangan->jumlah }}</td>
                    <td>{{ $pembuangan->kendaraan->rekanan->nama }}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#delete_{{$pembuangan->id}}">
                            Hapus
                        </button>
                        <div class="modal fade" id="delete_{{$pembuangan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog modal-dialog-centered">
                                   <div class="modal-content">
                                   <!-- Modal Header -->
                                       <div class="modal-header">
                                           <h4 class="modal-title">Hapus Data</h4>
                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <!-- Modal body -->
                                       <div class="modal-body">
                                           <form action="{{ route('pembuangan.destroy',$pembuangan->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                                <div class="form-group"> 
                                                    <p>Apakah Anda yakin untuk menghapus data ini?</p>
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
                @endforeach
            </tbody>
        </table>
@endif
                
            

