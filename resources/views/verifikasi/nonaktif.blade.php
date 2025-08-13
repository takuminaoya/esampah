@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pelanggan Nonaktif</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card widget widget-list">
                    <div class="card-header">
                        <h5 class="card-title">Pelanggan<span class="badge badge-danger badge-style-light">{{ $pelanggans->count() }} Nonaktif</span></h5>
                    </div>
                    <div class="card-body">
                        <ul class="widget-list-content list-unstyled">
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
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Aktifkan</button>
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

let biayas = $('.biaya');
$.each(biayas, function(index,biaya){
    priceFormat();
});

</script>
@endsection