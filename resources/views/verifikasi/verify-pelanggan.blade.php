@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Pelanggan Belum Terverifikasi</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card widget widget-list">
                    <div class="card-header">
                        <h5 class="card-title">Pelanggan<span class="badge badge-danger badge-style-light">{{ $customers->count() }} Belum Terverifikasi</span></h5>
                    </div>
                    <div class="card-body">
                        <ul class="widget-list-content list-unstyled">
                            @forelse ($customers as $customer)
                                <hr>
                                <li class="widget-list-item">
                                    <span class="widget-list-item-description">
                                        <a href="javascript:void(0)" class="widget-list-item-description-title" data-bs-target="#verifikasi{{ $customer->id }}" data-bs-toggle="modal">
                                            {{  $customer->nama  }}
                                        </a>
                                        <span class="widget-list-item-description-date">
                                            BR. {{  $customer->banjar->nama  }} | {{ $customer->email }}
                                        </span>
                                    </span>
                                    <span class="widget-list-item-product-amount">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasi{{ $customer->id }}">
                                           Detail
                                        </button>
                                    </span>
                                    <!-- Modal -->
                                    <div class="modal fade" id="verifikasi{{ $customer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel">
                                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <form action="{{ route('verifikasi.postVerifikasiPelanggan',$customer->id) }}" method="post">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pelanggan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <table class="col-sm-12 col-lg-6">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Nama</td>
                                                                        <td>: {{  $customer->nama  }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>NIK</td>
                                                                        <td>: {{  $customer->nik  }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Banjar</td>
                                                                        <td>: {{  $customer->banjar->nama  }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Telp</td>
                                                                        <td>: {{ $customer->telp }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Tanggal Daftar</td>
                                                                        <td>: {{ $customer->created_at->format('d-m-Y') }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="col-sm-12 col-lg-6">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Alamat</td>
                                                                        <td>: {{  $customer->alamat }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>: {{ $customer->email }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Nama Usaha</td>
                                                                        <td>: {{  $customer->usaha }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <label for="partner" class="col-sm-2 col-form-label"><b>Rekanan</b></label>
                                                            <div class="col-sm-10">
                                                                <select class="form-select m-b-md @error('partner') is-invalid @enderror" id="partner" name="partner" required>
                                                                    @foreach ($partners as $partner)
                                                                        <option value="{{ $partner->id }}">{{ $partner->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('partner')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="distribution_code_id" class="col-sm-2 col-form-label"><b>Kategori</b></label>
                                                            <div class="col-sm-10">
                                                                <select class="form-select m-b-md @error('distribution_code_id') is-invalid @enderror" id="distribution_code_id" name="distribution_code_id" required>
                                                                    @foreach ($distributionCodes as $distributionCode)
                                                                        <option value="{{ $distributionCode->id }}" {{ $distributionCode->id == $customer->distributionCode->id ? 'selected' : '' }}>{{ $distributionCode->objek }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('distribution_code_id')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <label for="fee" class="col-sm-2 col-form-label"><b>Biaya (Rp)</b></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control @error('fee') is-invalid @enderror biaya" id="fee"
                                                                    name="fee" placeholder="Masukkan fee yang harus dibayar customer tiap bulan" value="{{ $customer->distributionCode->jumlah }}" oninput="priceFormat(this.value)">
                                                                    @error('fee')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <label for="wa_message" class="col-sm-2 col-form-label"><b>Pesan Peninjauan</b></label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control" id="wa_message" rows="3" placeholder="Masukkan pesan peninjauan">Halo {{ $customer->nama }}, kami dari SPS Ungasan akan melakukan peninjauan ke lokasi Anda dalam waktu dekat. Terima kasih.</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <button type="button" class="btn btn-outline-success send-whatsapp" data-phone="{{ $customer->telp }}" data-name="{{ $customer->nama }}" data-csrf="{{ csrf_token() }}"><i class="fab fa-whatsapp"></i> Kirim Pesan Peninjauan</button>
                                                            <div class="d-flex gap-2">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Verifikasi</button>
                                                            </div>
                                                        </div>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Format all fee inputs
        let fees = $('.biaya');
        $.each(fees, function(index, fee) {
            priceFormat();
        });
        
        // Change fee when kategori is changed - use event delegation
        $(document).on('change', '.modal select[id="distribution_code_id"]', function() {
            let distributionCodeId = $(this).val();
            let modal = $(this).closest('.modal');
            let fee = modal.find('input[id="fee"]');
            
            $.ajax({
                url: '/verifikasi/get-fee/' + distributionCodeId,
                type: 'GET',
                success: function(data) {
                    fee.val(data);
                    priceFormat();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
    });
    </script>
<script src="{{ asset('js/whatsapp-notification.js') }}"></script>
@endpush