@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="page-description-actions">
                            @if(auth()->user()->level == 'admin')
                                <a href="{{ route('verifikasi.sync') }}" class="btn btn-primary btn-style-light"><i class="material-icons">sync</i>Sinkronisasi</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->level == false)
                @include('dashboard.user')
            @elseif (auth()->user()->level == 'petugas')
                @include('dashboard.petugas')
            @elseif (auth()->user()->level == 'bendahara')
                @include('dashboard.bendahara')
            @elseif (auth()->user()->level == 'admin')
                @include('dashboard.admin')    
            @endif
        </div>
    </div>
</div>


@endsection