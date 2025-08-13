@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pembayaran Anda</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-header">
                            <span>Formulir pembayaran transfer rekening</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pembayaran.postTransfer',$id) }}" method="post" enctype="multipart/form-data" id="submit">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $id }}">
                                <input type="hidden" class="form-control" id="isTransfer" name="isTransfer" value="1">
                                <input type="hidden" class="form-control" id="biaya" name="biaya" value="{{ $biaya }}">
                                <div class="row mb-3">
                                    <label for="status_bayar" class="col-sm-2 col-form-label">Pembayaran Bulan Ini</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="status_bayar" name="status_bayar" 
                                            value="{{ (getStatusBayar($id) == true)? 'Lunas' : 'Belum Lunas (Batas :'.getTenggat($id)->format('d-m-Y').')' }}" disabled>
                                    </div>
                                </div> 
                                <div class="row mb-3" id="bulan">
                                    <label for="bulan" class="col-sm-2 col-form-label">Pembayaran Bulan ke-</label>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            @foreach (getMonths($id) as $key => $month)
                                            @if ($loop->first || $loop->iteration == 7) <div class="col-sm-6"> @endif
                                            <div class="form-check">
                                                <input class="form-check-input @error('bulan_bayar') is-invalid @enderror" type="checkbox" value="{{ $key }}" 
                                                    id="{{ $key }}" name="bulan_bayar[]" onclick="getBiaya()"> 
                                                <label class="form-check-label" for="{{ $month }}">
                                                    {{ $month }} {{Carbon\Carbon::parse($key)->format('Y')}}
                                                </label>
                                            </div>
                                            @if ($loop->last || $loop->iteration == 6) </div> @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" id="total_bayar">
                                    <label for="total_bayar" class="col-sm-2 col-form-label">Total Bayar (Rp)</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="total" class="form-control biaya" name="total" value="0" readonly>
                                        <input type="number" id="total_hidden" name="biaya" value="{{ $biaya }}" hidden>
                                    </div>
                                </div>
                                <div class="row mb-3" id="bukti_bayar">
                                    <label for="bukti_bayar" class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control @error('bukti_bayar') is-invalid @enderror" id="bukti_bayar" name="bukti_bayar">
                                        @error('bukti_bayar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> 
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Simpan</button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Simpan Data Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda Yakin Ingin Menyimpan Data Ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                                                <button type="submit" id="submit" class="btn btn-primary" data-bs-target="#submit">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    
function getBiaya(){
    let jumlah = $('#bulan').find('.form-check-input:checked').length;
    let biaya = $('#total_hidden').val();
    let total = jumlah * biaya
    $('#total').val(total);
    priceFormat();
}

    
</script>

@endsection