@extends('layout.backend.core')

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pengambilan</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pengambilan Sampah</h5>
                    </div>
                    <div class="card-body">
                        @include('pengambilan.datatable')
                    </div>
                </div>
            </div>       
        </div>
    </div>
</div>
            

@endsection