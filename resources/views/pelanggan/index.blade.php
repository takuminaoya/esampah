@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    @if (auth()->user()->level == 'admin' || auth()->user()->level == 'bendahara')
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h1>Pelanggan</h1>
                                <span>Data pelanggan tahun {{ Carbon\Carbon::today()->format('Y') }}</span>
                            </div>
                            <div class="page-description-actions">
                                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-style-light"><i class="material-icons">add</i>Tambah Pelanggan</a>
                                <a href="{{ route('pelanggan.export') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Excel</a>
                                @if(request('group'))
                                    <a href="{{ route('pelanggan.cetak') }}?group={{ request('group') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>PDF</a>
                                @elseif(request('rekanan'))
                                    <a href="{{ route('pelanggan.cetak') }}?rekanan={{ request('rekanan') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Cetak</a>
                                @else
                                    <a href="{{ url('/pelanggan/cetak') }}" class="btn btn-primary btn-style-light"><i class="material-icons">download</i>Cetak</a>
                                @endif

                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="dropdown">
                                <span class="text-center align-center"><b>Rekanan : </b></span>
                            </div>
                            <div class="btn-group">
                                @if(!request('rekanan'))
                                <button class="btn btn-light" type="button">Cipta Ungasan Bersih</button>
                                @else
                                    <button class="btn btn-light" type="button">{{ getNamaRekanan(request('rekanan')) }}</button>
                                @endif
                                <button type="button" class="btn btn-primary btn-style-light  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($rekanans as $rekanan)
                                        <li><a class="dropdown-item" href="{{ route('pelanggan.index') }}?rekanan={{ $rekanan->id }}">{{ $rekanan->nama }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                           
                        </div>
                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ url('/pelanggan') }}" class="nav-link {{ (!request('group'))? 'active' : '' }}" id="home-tab" type="button" role="tab" aria-controls="home" >Semua</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ url('/pelanggan?group=A') }}" class="nav-link {{ (request('group') == "A")? 'active' : '' }}" id="profile-tab" type="button" role="tab" aria-controls="profile" >Group A</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ url('/pelanggan?group=B') }}" class="nav-link {{ (request('group') == "B")? 'active' : '' }}" id="contact-tab" type="button" role="tab" aria-controls="contact" >Group B</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        @include('pelanggan.datatable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <form action="{{ route('pelanggan.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="input-group mb-3">
        <input type="file" name="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
    </div>
</form> --}}

@if(session()->has('status'))
    @include('layout.backend.alert')
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://unpkg.com/@popperjs/core@2"></script> 
@endsection