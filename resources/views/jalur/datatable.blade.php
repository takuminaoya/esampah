@if (auth()->user()->level == 'admin')
        <table class="table table-responsive">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Jalur</th>
                    <th>Banjar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jalurs as $jalur)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jalur->nama }}</td>
                    <td>
                        @foreach ($details as $detail)
                            @if ($detail->jalur_id == $jalur->id)
                                {{ $detail->banjar->nama }},
                            @endif
                        @endforeach
                    </td>
                    <td class="text-center"> 
                        @if ($jalur->status == true)
                            <button type="button" class="btn btn-success btn-style-light" data-bs-toggle="modal" data-bs-target="#verify{{$jalur->id}}">
                                Aktif
                            </button>
                        @else 
                            <button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#verify{{$jalur->id}}">
                                Nonaktif
                            </button>
                        @endif
                    
                        <div class="modal fade" id="verify{{$jalur->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{($jalur->status == true)? 'Nonaktifkan Jalur':'Aktifkan Jalur'}}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form action="{{ route('jalur.postUpdateStatus',$jalur->id) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                            <div class="form-group"> 
                                                <p>Saat ini jalur sedang {{($jalur->status == true)? 'aktif':'nonaktif'}}
                                                    Apakah Anda yakin untuk {{($jalur->status == true)? 'mengnonaktifkan':'mengaktifkan'}} jalur ini?</p>
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
                    <td class="text-center">
                        <a href="{{ route('jalur.edit', $jalur->id) }}" class="btn btn-info btn-style-light">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-style-light" data-bs-toggle="modal" data-bs-target="#delete{{$jalur->id}}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                        
                        <!-- Delete Modal -->
                        <div class="modal fade" id="delete{{$jalur->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus Jalur</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('jalur.destroy', $jalur->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="form-group"> 
                                                <p>Apakah Anda yakin ingin menghapus jalur <strong>{{ $jalur->nama }}</strong>?</p>
                                                <p class="text-danger">Perhatian: Semua data terkait jalur ini juga akan dihapus.</p>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
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
                
            

