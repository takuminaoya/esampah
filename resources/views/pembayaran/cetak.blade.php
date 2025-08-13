@extends('layout.backend.cetak')

@section('judul','DATA PELANGGAN CIPTA UNGASAN BERSIH')
@section('tahun','TAHUN 2022')

@section('content') 
<body>    
    <div class="table-responsive-lg">
        @if(!request('rekanan'))
        <table class="table table-bordered">
            <thead>
                <tr class="align-middle">
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Nama Usaha</th>
                    <th rowspan="2">Alamat</th>
                    <th rowspan="2">Biaya Retribusi</th>
                    <th rowspan="2">Group</th>
                    <th rowspan="2">Mulai Langganan</th>
                    <th rowspan="2">RAP</th>
                    <th colspan="12" class="text-center">Pembayaran</th>
                </tr>
                <tr>
                    @foreach (getMonthsYear() as $month)
                        <th>{{ $month }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $j = 1;
                @endphp
                @forelse ($pelanggans as $pelanggan)
                    @if($pelanggan->rekanan_id == 1)
                    <tr>
                        <td>{{  $j++  }}</td>
                        <td>{{  $pelanggan->nama  }}</td>
                        <td>{{ $pelanggan->usaha }}</td>
                        <td>{{  $pelanggan->alamat }}</td>   
                        <td>{{ $pelanggan->biaya }}</td>
                        <td>{{ getJalur($pelanggan->id) }}</td>
                        <td>{{ Carbon\Carbon::parse($pelanggan->tgl_verified)->format('d-m-Y') }}</td>
                        <td>{{ number_format($pelanggan->biaya,0) }}</td>
                        @foreach($months as $month)
                            @foreach (getDetailPembayaran($pelanggan->id) as $bulan => $detail)
                                @if($bulan == Carbon\Carbon::parse($month)->format('F'))
                                    <td>{{ number_format($detail,0) }}</td>
                                @endif
                            @endforeach
                        @endforeach
                    </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="20" class="text-center">
                            <p>Tidak ada data</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <th colspan="8" class="text-center">Total</th>
                @foreach($jumlah as $jml)
                    <th>{{ number_format($jml,0) }}</th>
                @endforeach
                {{-- <th>{{ number_format($subtotal,0) }}</th> --}}
            </tfoot>
        </table>
        @else
        <table class="table table-bordered">
        <thead>
            <tr class="align-middle">
                <th rowspan="2">No.</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Nama Usaha</th>
                <th rowspan="2">Alamat</th>
                <th rowspan="2">Biaya Retribusi</th>
                <th rowspan="2">Group</th>
                <th rowspan="2">Mulai Langganan</th>
                <th rowspan="2">RAP</th>
                <th colspan="12" class="text-center">Pembayaran</th>
            </tr>
            <tr>
                @foreach (getMonthsYear() as $month)
                    <th >{{ $month }}</th>
                @endforeach
            </tr>

        </thead>
        <tbody>
            @php
                $k = 1;
            @endphp
            @forelse ($pelanggans as $pelanggan)
                @if($pelanggan->rekanan_id == request('rekanan'))
                    <tr>
                        <td>{{  $k++  }}</td>
                        <td>{{  $pelanggan->nama  }}</td>
                        <td>{{ $pelanggan->usaha }}</td>
                        <td>{{  $pelanggan->alamat }}</td>   
                        <td>{{ $pelanggan->biaya }}</td>
                        <td>{{ getJalur($pelanggan->id) }}</td>
                        <td>{{ Carbon\Carbon::parse($pelanggan->tgl_verified)->format('d-m-Y') }}</td>
                        <td>{{ $pelanggan->biaya }}</td>

                        @foreach($months as $month)
                            @foreach (getDetailPembayaran($pelanggan->id) as $bulan => $detail)
                                @if($bulan == Carbon\Carbon::parse($month)->format('F'))
                                    <td>{{ number_format($detail,0) }}</td>
                                @endif
                            @endforeach
                        @endforeach 
                    </tr>
                @endif
            @empty
            <tr>
                <td colspan="20" class="text-center">
                    <p>Tidak ada data</p>
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <th colspan="8" class="text-center">Total</th>
            @foreach($jumlah as $jml)
                <th>{{ number_format($jml,0) }}</th>
            @endforeach
            {{-- <th>{{ number_format($subtotal,0) }}</th> --}}
        </tfoot>
    </table>
@endif
