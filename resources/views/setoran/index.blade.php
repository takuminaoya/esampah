@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Uang Yang Belum Disetor</h1>
                            <span>Pelanggan yang sudah membayar namun belum diverifikasi bendahara</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        @include('setoran.datatable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection