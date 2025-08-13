@if (auth()->user()->level == 'admin')
        <table class="table table-responsive">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Kode</th>
                    <th>Objek</th>
                    <th>Kategori</th>
                    <th class="text-end">Biaya (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($distribusis as $distribusi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $distribusi->kode }}</td>
                    <td class="text-left">{{ $distribusi->objek }}</td>
                    @if($distribusi->kategori == '1')
                        <td>Pribadi</td>
                    @elseif($distribusi->kategori == '2')
                        <td>Usaha</td>
                    @endif
                    <td class="text-end">{{ number_format($distribusi->jumlah,0) }}</td>
                    <td class="text-center">
                        <a href="{{ route('kode-distribusi.edit',$distribusi->id) }}" class="btn btn-info btn-style-light">Edit</a>
                
                        <button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#delete_{{$distribusi->id}}">
                            Delete
                        </button>
                        <div class="modal fade" id="delete_{{$distribusi->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog modal-dialog-centered">
                                   <div class="modal-content">
                                   <!-- Modal Header -->
                                       <div class="modal-header">
                                           <h4 class="modal-title">Hapus Data</h4>
                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <!-- Modal body -->
                                       <div class="modal-body">
                                           <form action="{{ route('kode-distribusi.destroy',$distribusi->id) }}" method="POST">
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
                
            

