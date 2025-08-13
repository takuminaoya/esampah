@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pelanggan Kadaluarsa</h1>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('verifikasi.getKadaluarsa') }}" class="nav-link {{ (!request('waktu'))? 'active' : '' }}" id="home-tab" type="button" role="tab" aria-controls="home" >Kadaluarsa</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ url('verifikasi/kadaluarsa?waktu=1') }}" class="nav-link {{ (request('waktu') == "1")? 'active' : '' }}" id="profile-tab" type="button" role="tab" aria-controls="profile" >H-1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ url('verifikasi/kadaluarsa?waktu=3') }}" class="nav-link {{ (request('waktu') == "3")? 'active' : '' }}" id="profile-tab" type="button" role="tab" aria-controls="profile" >H-3</a>
                </li>
            </ul>
            <div class="col-xl-12">
                <div class="card widget widget-list">
                    <div class="card-header">
                        <h5 class="card-title">Pelanggan<span class="badge badge-danger badge-style-light">{{ $pelanggans->count() }} Kadaluarsa</span></h5>
                    </div>
                    <div class="card-body">
                        <ul class="widget-list-content list-unstyled">
                            @php
                                $i = 0;
                            @endphp
                            @forelse ($pelanggans as $pelanggan)
                                <hr>
                                <li class="widget-list-item">
                                    <span class="widget-list-item-description">
                                        <a href="javascript:void(0)" class="widget-list-item-description-title" data-bs-target="#verifikasi{{ $pelanggan->id }}" data-bs-toggle="modal">
                                            {{  $pelanggan->nama  }}
                                        </a>
                                        <span class="widget-list-item-description-date">
                                            BR. {{  $pelanggan->banjar->nama  }} | Lunas
                                        </span>
                                    </span>
                                    <span class="widget-list-item-product-amount">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasi{{ $pelanggan->id }}">
                                           Detail
                                        </button>
                                    </span>
                                    <!-- Modal -->
                                    <div class="modal fade" id="verifikasi{{ $pelanggan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Pembayaran {{ Carbon\Carbon::today()->format('Y') }}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('pelanggan.updateStatus',$pelanggan->id) }}" method="post">
                                                    @method('patch')
                                                    @csrf 
                                                    <input type="hidden" value="{{ $pelanggan->telp }}" id="telp">
                                                    <div class="modal-body">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    @foreach (getMonthsYear() as $month)
                                                                        <th>{{ $month }}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    @foreach ($pelanggan->pembayaran as $pembayaran)
                                                                        @foreach ($pembayaran->detailPembayaran as $detail)
                                                                            <td>{{ $detail->biaya }}</td>
                                                                        @endforeach
                                                                    @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                   
                                                    <div class="modal-footer">
                                                        @if(request('waktu') == "1")
                                                            <button type="button" onclick="kirimPesanH1()" class="btn btn-secondary">Kirim Pemberitahuan</button>
                                                        @elseif(request('waktu') == "3")
                                                            <button type="button" onclick="kirimPesanH3()" class="btn btn-secondary">Kirim Pemberitahuan</button>
                                                        @endif
                                                        <button type="submit" id="submit" onclick="kirimPesanNonaktif()" class="btn btn-primary submit" data-bs-target="#submit">Nonaktifkan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Tidak ada data</p>
                                    </td>
                                </tr>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
@if(session()->has('status'))
    @include('layout.backend.alert')
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
 $(document).ready(function () {
    let biayas = $('.biaya');
    $.each(biayas, function(index,biaya){
        priceFormat();
    });
});

function kirimPesanNonaktif(){
    let klik = $('#submit');
    let phone = $('#telp').val();

    var pesan = "Akun Anda telah dinonaktifkan. Silahkan melakukan pembayaran untuk mengaktifkan akun kembali";

    window.open('https://wa.me/'+phone+'/?text='+pesan , "_blank");
}

function kirimPesanH1(){
    let klik = $('#submit');
    let phone = $('#telp').val();

    var pesan = "1 hari tersisa untuk melakukan pembayaran sebelum akun Anda dinonaktifkan";

    window.open('https://wa.me/'+phone+'/?text='+pesan , "_blank");
}

function kirimPesanH3(){
    let klik = $('#submit');
    let phone = $('#telp').val();

    var pesan = "3 hari tersisa untuk melakukan pembayaran sebelum akun Anda dinonaktifkan";

    window.open('https://wa.me/'+phone+'/?text='+pesan , "_blank");
}



    
</script>
@endsection