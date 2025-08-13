@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pembayaran Belum Terverifikasi</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card widget widget-list">
                    <div class="card-header">
                        <h5 class="card-title">Pembayaran Transfer<span class="badge badge-danger badge-style-light">{{ $transfers->count() }} Belum Terverifikasi</span></h5>
                    </div>
                    <div class="card-body">
                        <ul class="widget-list-content list-unstyled">
                            @forelse ($transfers as $transfer)
                                <hr>
                                <li class="widget-list-item">
                                    <span class="widget-list-item-icon widget-list-item-icon-large">
                                        <a href="../storage/{{ $transfer->bukti_bayar }}" target="_blank">
                                        <div class="widget-list-item-icon-image" style="background: url('../storage/{{ $transfer->bukti_bayar }}')"></div>
                                    </a></span>
                                    <span class="widget-list-item-description">
                                        <a href="#" class="widget-list-item-description-title">
                                            {{ $transfer->user->nama }}
                                        </a>
                                        <input type="hidden" id="no_wa" value="{{ $transfer->user->telp }}">
                                        <span class="widget-list-item-description-date">
                                            Pembayaran Bulan :
                                            @foreach ($details as $detail) 
                                                @if($detail->pembayaran_id == $transfer->id) 
                                                    {{ Carbon\Carbon::parse($detail->bulan_bayar)->isoFormat('MMMM Y') }},
                                                @endif
                                            @endforeach
                                            <br>
                                            Tanggal : {{ $transfer->created_at->format('d-m-Y') }}
                                            <br>
                                            <b> Total Bayar : Rp. {{ number_format($transfer->total,0) }}</b>
                                        </span>
                                    </span>
                                    <span class="widget-list-item-product-amount">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verify_{{$transfer->id}}">
                                            Verifikasi
                                         </button>
                                    </span>
                                
                                     <div class="modal fade" id="verify_{{$transfer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Verifikasi Pembayaran Transfer</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <form action="{{ route('verifikasi.postVerifikasiTransfer',$transfer->id) }}" method="POST">
                                                         @csrf
                                                         @method('patch')
                                                             <div class="form-group"> 
                                                                 <p>Apakah Anda yakin untuk memverifikasi pembayaran ini?</p>
                                                             </div>
                                                             <div class="d-flex justify-content-between">
                                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                 <button type="submit" onclick="kirimPesan()" class="btn btn-primary" >Ya </button>
                                                             </div>
                                                        </form>
                                                    </div>
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

<script>
   function kirimPesan(){
    let pesan = "Terimakasih, Pembayaran via trasfer ke Cipta Ungasan Bersih telah sebesar Rp " + $('#total').val() + " telah diterima";
    let phone = $("#no_wa").val();;

    window.open('https://wa.me/'+phone+'/?text='+pesan, "_blank");
} 
</script>


@endsection