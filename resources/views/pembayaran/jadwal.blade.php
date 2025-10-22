@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-description">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pembayaran</h1>
                            <span>Pembayaran dapat dilakukan di halaman ini </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="\" class="table display" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tenggat Pembayaran</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Status Bulan Ini</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggans as $pelanggan)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td scope="row">{{ getTenggat($pelanggan->id)->format('d F Y') }}</td>
                                <td scope="row">{{ $pelanggan->nama }}</td>
                                <td scope="row">{{ $pelanggan->alamat }}</td>
                                <td scope="row">{{ (getStatusBayar($pelanggan->id) == true)? 'Lunas' : 'Belum Lunas' }}</td>
                                <td scope="row">
                                    <a class="btn btn-style-light btn-primary" href="{{ route('pembayaran.create', $pelanggan->id) }}">Bayar</a>
                                </td>
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
            </div>
        </div>
    </div>
</div>

@endsection