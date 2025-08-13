@extends('layout.backend.core')

@section('content')

<div class="container">
    <div class="row">
        <div class="d-flex align-content-center">
        <div class="page-description col-lg-6 col-sm-12">
            <h1 class="mb-4">Ciptakan Ungasan Bersih</h1>
            <h4 class="mb-4">Mari ciptakan lingkungan yang bersih dengan berlangganan </h4>
            <a href="{{ route('getRegistrasi') }}" class="btn btn-primary mt-3">Mulai Berlangganan</a>
        </div>
            <div class="col-lg-6 order-1 order-lg-2">
                <img src="{{ asset('images/backgrounds/volunter.png') }}" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>
</div>
@endsection