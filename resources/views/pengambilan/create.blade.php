@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pengambilan Hari Ini</h1>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card widget widget-popular-blog">
                            <div class="card-header">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">{{ $pelanggan->nama }}</label>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pengambilan.store',$pelanggan->id) }}" method="post" enctype="multipart/form-data" id="submit">
                                    @csrf
                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $pelanggan->id }}">
                                    <input type="hidden" class="form-control" id="biaya" name="biaya" value="{{ $pelanggan->biaya }}">
                                    <input type="hidden" class="form-control" id="no_wa" name="no_wa" value="{{ $pelanggan->telp }}">
                                    <div class="row mb-3">
                                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="alamat" placeholder="{{ $pelanggan->alamat }}" readonly>
                                        </div>
                                    </div>
                                    <fieldset class="row mb-3">
                                        <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                                        <div class="col-sm-10">
                                            <div class="form-check status_ambil">
                                                <input class="form-check-input status" type="radio" name="status" id="status" value="1" checked>
                                                <label class="form-check-label" for="status">
                                                    Ambil
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="status2" value="2" {{ @old('status') == '2' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="status2">
                                                    Tidak Ambil
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </fieldset>
                                    <div class="row mb-3 alasan" style="{{ $errors->has('alasan') ? '' : 'display: none;' }}" id="alasann">
                                        <label for="alasan" class="col-sm-2 col-form-label">Alasan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('alasan') is-invalid @enderror" id="alasan" name="alasan" value="{{ @old('alasan')}}">
                                            @error('alasan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="row mb-3">
                                        <label for="gambar" class="col-sm-2 col-form-label">Foto</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                                            @error('gambar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="row mb-3">
                                        <label for="isLunas" class="col-sm-2 col-form-label">Pembayaran Bulan Ini</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="isLunas" name="isLunas" 
                                                value="{{ ($status == '1')? 'Lunas' : 'Belum Lunas (Batas :'.getTenggat($pelanggan->id)->format('d-m-Y').')' }}" disabled>
                                        </div>
                                    </div> 
                                    <div class="row mb-3 mt-4 ms-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input pembayaranCheck" type="checkbox" id="pembayaranCheck" onclick="getPembayaran()">
                                            <label class="form-check-label" for="pembayaranCheck">Langsung melakukan pembayaran</label>
                                        </div>
                                    </div>
                                    <div id="pembayaran" style="display: none;">
                                        <input type="hidden" class="form-control" id="status_bayar" name="status_bayar" value="0">
                                        <div class="row mb-3 mt-2" id="bulan">
                                            <label for="bulan" class="col-sm-2 col-form-label">Pembayaran Bulan ke-</label>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    @foreach (getMonths($pelanggan->id) as $key => $month)
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
                                                <input type="number" id="total_hidden" name="biaya" value="{{ $pelanggan->biaya }}" hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">Simpan</button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Simpan Data Pengambilan</h5>
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
    $(document).ready(function () {
        $('#status').on('click', function () {
            
                $('#alasann').hide();
            
        }); 
        $('#status2').on('click', function () {
                $('#alasann').show();
            
        });

    });

        function getPembayaran(){
           let jml = $('.form-switch').find('.pembayaranCheck:checked').length;
            if(jml == 0){
                $('#pembayaran').hide();
                $('#status_bayar').val(0)
            }else{
                $('#pembayaran').show();
                $('#status_bayar').val(1)
            } 
        }
    
        function getBiaya(){
            let jumlah = $('#bulan').find('.form-check-input:checked').length;
            let biaya = $('#total_hidden').val();
            let total = jumlah * biaya
            $('#total').val(total);
            priceFormat();
        }

        function kirimPesan(){
            // let tes = $('#bulan').find('.form-check-input:checked');
            // $.each()
            // console.log(tes);
            let jml = $('.form-switch').find('.pembayaranCheck:checked').length;
          
            let status2 = $('.status_ambil').find('.status:checked').length;
            let phone = $("#no_wa").val();

            if(status2 !== 0){
                var pesan_ambil = "Sampah Anda telah diambil oleh petugas Cipta Ungasan Bersih ";
            }else{
                var pesan_ambil = "Sampah Anda tidak diambil oleh petugas Cipta Ungasan Bersih karena " +$('#alasan').val();
            }

            if($('#status_bayar').val() == 0){
                window.open('https://wa.me/'+phone+'/?text='+pesan_ambil , "_blank");
            }else{
                var pesan_bayar = "Terimakasih sudah melakukan pembayaran sebesar Rp " + $('#total').val();
                window.open('https://wa.me/'+phone+'/?text='+pesan_ambil+' dan '+pesan_bayar , "_blank");
            } 
    

        }
    
</script>

@endsection