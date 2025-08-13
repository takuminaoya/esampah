@if (auth()->user()->level == 'admin')
        <table class="table table-responsive">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Jalur</th>
                    <th>Banjar</th>
                    <th>Status</th>
                    {{-- <th>Aksi</th> --}}
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
                    {{-- <td>
                        <button type="button" class="btn btn-info btn-style-light" data-bs-toggle="modal" data-bs-target="#edit_{{$jalur->id}}">
                            Edit
                        </button>
                            <div class="modal fade" id="edit_{{$jalur->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Jalur</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="{{ route('jalur.update',$jalur->id) }}" method="POST">
                                                @csrf
                                        
                                                @foreach ($banjars as $banjar)
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="banjars[]" type="checkbox" value="{{ $banjar->id }}" id="{{ $banjar->id }}" 
                                                        @foreach ($details as $detail)
                                                        @if($detail->jalur_id == $jalur->id && $detail->banjar_id == $banjar->id)
                                                            checked
                                                        @endif
                                                       
                                                        @endforeach >
                                                        <label class="form-check-label" for="{{ $banjar->id }}">
                                                            {{ $banjar->nama }}
                                                        </label>
                                                    </div>
                                                @endforeach
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
                @endforeach
            </tbody>
        </table>
@endif
                
            

