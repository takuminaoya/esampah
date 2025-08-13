@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Tambah Pendapatan</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-body">
                            <form action="{{ route('pendapatan.store') }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan">
                                        @error('keterangan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bulan_bayar" class="col-sm-2 col-form-label">Bulan</label>
                                    <div class="col-sm-10">
                                        <input type="month" class="form-control @error('bulan_bayar') is-invalid @enderror" id="bulan_bayar" name="bulan_bayar" value="{{ date('Y-m') }}">
                                        @error('bulan_bayar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="isTransfer" class="col-sm-2 col-form-label">Jenis Pembayaran</label>
                                    <div class="col-sm-10">
                                        <select class="form-select @error('isTransfer') is-invalid @enderror" id="isTransfer" name="isTransfer" required>
                                            <option value="0">Cash</option>
                                            <option value="1">Transfer</option>
                                        </select>
                                        @error('isTransfer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="jenis_pendapatan" class="col-sm-2 col-form-label">Jenis Pendapatan</label>
                                    <div class="col-sm-10">
                                        <select class="form-select @error('jenis_pendapatan') is-invalid @enderror" id="jenis_pendapatan" name="jenis_pendapatan">
                                            <option value="">--Pilih Pendapatan--</option>
                                            @foreach ($jenis_pendapatans as $jenis_pendapatan)
                                                <option value="{{ $jenis_pendapatan->id }}">{{ $jenis_pendapatan->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis_pendapatan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah (Rp)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah">
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-end">Simpan</button>
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

$('#jumlah').val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  }).keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;
      // format number
      $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
      });
});


</script>
@endsection