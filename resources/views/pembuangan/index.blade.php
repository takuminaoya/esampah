@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Rekap Pembuangan</h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="{{ route('pembuangan.create') }}" class="btn btn-primary btn-style-light"><i class="material-icons">add</i>Tambah Data</a>
                            <a href="{{ route('pembuangan.cetak') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Cetak</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        @include('pembuangan.datatable')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Plat</th>
                                    @foreach ($kendaraans as $kendaraan)
                                        @foreach ($total as $tot)
                                            @if ($kendaraan->id == $tot->kendaraan_id)
                                                <th>{{ $kendaraan->plat }} ({{ $kendaraan->rekanan->nama }})</th>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th>Jumlah</th>
                                @foreach ($kendaraans as $kendaraan)
                                    @foreach ($total as $tot)
                                        @if ($kendaraan->id == $tot->kendaraan_id)
                                            <td>{{ $tot->jumlah}} x Rp 100.000 </td>
                                        @endif
                                    @endforeach
                                @endforeach
                                
                            </tr>
                            </tbody>
                            <tfoot>
                                <th>Total</th>
                                @foreach ($kendaraans as $kendaraan)
                                    @foreach ($total as $tot)
                                        @if ($kendaraan->id == $tot->kendaraan_id)
                                            <td>Rp {{ number_format($tot->total,0) }}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@endsection