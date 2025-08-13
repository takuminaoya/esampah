@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Petugas</h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="{{ route('petugas.create') }}" class="btn btn-primary btn-style-light"><i class="material-icons">add</i>Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        @include('petugas.datatable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            

@endsection