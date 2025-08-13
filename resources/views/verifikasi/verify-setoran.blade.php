@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Verifikasi Setoran</h1>
                            <span>Petugas yang belum menyetor iuran pelanggan</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card widget widget-list">
                    <div class="card-header">
                        <h5 class="card-title">Petugas<span class="badge badge-danger badge-style-light">{{ $petugass->count() }} Belum Terverifikasi</span></h5>
                    </div>
                    <div class="card-body">
                        <ul class="widget-list-content list-unstyled">
                            @forelse ($petugass as $petugas)
                                <hr>
                                <li class="widget-list-item">
                                    <span class="widget-list-item-description">
                                        <a href="javascript:void(0)" class="widget-list-item-description-title" data-bs-target="#verifikasi{{ $petugas->id }}" data-bs-toggle="modal">
                                            {{  $petugas->nama  }}
                                        </a>
                                        <span class="widget-list-item-description-date">
                                            Kewajiban Penyetoran : 
                                            @foreach($totals as $total)
                                                @if($petugas->id == $total->pegawai_id)
                                                   <b>Rp {{ number_format($total->total,0) }}</b> 
                                                @endif
                                            @endforeach
                                        </span>
                                    </span>
                                    <span class="widget-list-item-product-amount">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verifikasi{{ $petugas->id }}">
                                           Detail
                                        </button>
                                    </span>
                                    <!-- Modal -->
                                    <div class="modal fade" id="verifikasi{{ $petugas->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <form action="{{ route('verifikasi.postVerifikasiSetoran',$petugas->id) }}" method="post">
                                                    @method('patch')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Setoran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="col-sm-12">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"></th>
                                                                    <th scope="col">Pelanggan</th>
                                                                    <th scope="col">Banjar</th>
                                                                    <th scope="col">Tanggal Bayar</th>
                                                                    <th scope="col">Total (Rp)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($petugas->pembayaran as $setoran)
                                                                    @if($setoran->verifikasi_bendahara == false)
                                                                        <tr>
                                                                            <td scope="row"><input class="form-check-input" value="{{ $setoran->id }}" name="setoran[]" type="checkbox" id="{{ $setoran->id }}" checked></td>
                                                                            <td scope="row">{{ $setoran->user->nama }}</td>
                                                                            <td scope="row">{{ $setoran->user->banjar->nama }}</td>
                                                                            <td scope="row">{{ $setoran->created_at->format('d-m-Y') }}</td>
                                                                            <td scope="row">{{ number_format($setoran->total,0) }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Verifikasi</button>
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