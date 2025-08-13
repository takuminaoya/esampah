@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Kode Distribusi</h1>
                        </div>
                        <div class="page-description-actions">
                            <a href="{{ route('kode-distribusi.create') }}" class="btn btn-warning btn-style-light"><i class="material-icons">add</i>Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        @include('kode-distribusi.datatable')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <form action="{{ route('kode-distribusi.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="input-group mb-3">
        <input type="file" name="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
    </div>
</form>
             --}}
@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@endsection