@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pendapatan</h1>
                            <span>Data pendapatan tahun {{ Carbon\Carbon::today()->format('Y') }}</span>
                        </div>
                        <div class="page-description-actions">
                            @if (request('pendapatanLain'))
                                <a href="{{ url('/pendapatan/cetak?pendapatanLain=1') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Cetak</a>
                            @elseif(request('isTransfer'))
                                <a href="{{ url('/pendapatan/cetak?isTransfer=1') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Cetak</a>
                            @else
                                <a href="{{ route('pendapatan.create') }}" class="btn btn-primary btn-style-light"><i class="material-icons">add</i>Tambah Pendapatan</a>
                                <a href="{{ route('pendapatan.cetak') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Cetak</a>
                            @endif
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('/pendapatan') }}" class="nav-link {{ (!request('pendapatanLain') && !request('isTransfer'))? 'active' : '' }}" id="home-tab" type="button" role="tab" aria-controls="home" >Total Pendapatan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('/pendapatan?pendapatanLain=1') }}" class="nav-link {{ (request('pendapatanLain'))? 'active' : '' }}" id="profile-tab" type="button" role="tab" aria-controls="profile" >Pendapatan Lain-Lain</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ url('/pendapatan?isTransfer=1') }}" class="nav-link {{ (request('isTransfer'))? 'active' : '' }}" id="contact-tab" type="button" role="tab" aria-controls="contact" >Pendapatan Transfer</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        @include('pendapatan.datatable')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        Total Pendapatan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    @foreach ($jumlah as $jml)
                                        <th>{{ $jml->bulan }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Jumlah</th>
                                    @foreach ($jumlah as $jml)
                                        <td>{{ number_format($jml->jumlah,0) }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total per tahun (Rp)</th>
                                    <th colspan="11">{{ number_format($total,0) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <form action="{{ route('pendapatan.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="input-group mb-3">
        <input type="file" name="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
    </div>
</form> --}}
@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@endsection