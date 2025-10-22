@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Detail</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Nama Usaha</th>
                                    <th>Banjar</th>
                                    <th>Group</th>
                                    <th>Mulai Langganan</th>
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
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
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
    </div>
</div>
</div>
        

@endsection