@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pengambilan Hari Ini</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($pelanggans as $pelanggan)
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-header">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">{{ $pelanggan->nama }}</label>
                            <span>({{ $pelanggan->kode_pelanggan }})</span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="banjar" class="col-sm-2 col-form-label">Banjar</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="banjar" placeholder="{{ $pelanggan->banjar->nama }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="alamat" placeholder="{{ $pelanggan->alamat }}" readonly>
                                </div>
                            </div>
                           
                                <a class="btn btn btn-outline-primary col-12 float-end" href="{{ route('pengambilan.create', $pelanggan->id) }}">Ambil</a>
                               
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@endsection