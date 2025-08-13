@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pelanggan Belum Terverifikasi</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card widget widget-list">
                    <div class="card-header">
                        <h5 class="card-title">Pelanggan<span class="badge badge-danger badge-style-light">{{ $pelanggans->count() }} Belum Terverifikasi</span></h5>
                    </div>
                    <div class="card-body">
                        <ul class="widget-list-content list-unstyled">
                            @forelse ($pelanggans as $pelanggan)
                                <hr>
                                <li class="widget-list-item">
                                    <span class="widget-list-item-description">
                                        <a href="javascript:void(0)" class="widget-list-item-description-title" data-bs-target="#verifikasi{{ $pelanggan->id }}" data-bs-toggle="modal">
                                            {{  $pelanggan->nama  }}
                                        </a>
                                        <span class="widget-list-item-description-date">
                                            BR. {{  $pelanggan->banjar->nama  }} | {{ $pelanggan->email }}
                                        </span>
                                    </span>
                                    <span class="widget-list-item-product-amount">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasi{{ $pelanggan->id }}">
                                           Detail
                                        </button>
                                    </span>
                                    <!-- Modal -->
                                    <div class="modal fade" id="verifikasi{{ $pelanggan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <form action="{{ route('verifikasi.postVerifikasiPelanggan',$pelanggan->id) }}" method="post">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pelanggan</h5>
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
                                                                        <td>: {{  $pelanggan->banjar->nama  }}</td>
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
                                                                        <td>: {{ $pelanggan->kodeDistribusi->objek }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Nama Usaha</td>
                                                                        <td>: {{  $pelanggan->usaha }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <label for="rekanan" class="col-sm-2 col-form-label"><b>Rekanan</b></label>
                                                            <div class="col-sm-10">
                                                                <select class="form-select m-b-md @error('rekanan') is-invalid @enderror" id="rekanan" name="rekanan" required>
                                                                    @foreach ($rekanans as $rekanan)
                                                                        <option value="{{ $rekanan->id }}">{{ $rekanan->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('rekanan')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="biaya" class="col-sm-2 col-form-label"><b>Biaya (Rp)</b></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control @error('biaya') is-invalid @enderror biaya" id="biaya"
                                                                    name="biaya" placeholder="Masukkan biaya yang harus dibayar pelanggan tiap bulan" value="{{ $pelanggan->kodeDistribusi->jumlah }}" oninput="priceFormat(this.value)">
                                                                    @error('biaya')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Verifikasi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Tidak ada data</p>
                                    </td>
                                </tr>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
@if(session()->has('status'))
    @include('layout.backend.alert')
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

let biayas = $('.biaya');
$.each(biayas, function(index,biaya){
    priceFormat();
});

</script>
@endsection