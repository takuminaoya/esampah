@extends('layout.backend.cetak')

@if (request('isTransfer'))
    @section('judul','PENDAPATAN TRANSFER CIPTA UNGASAN BERSIH')
    @section('tahun','TAHUN 2022')
@elseif (request('pendapatanLain'))
    @section('judul','PENDAPATAN LAIN-LAIN CIPTA UNGASAN BERSIH')
    @section('tahun','TAHUN 2022')
@else
    @section('judul','TOTAL PENDAPATAN CIPTA UNGASAN BERSIH')
    @section('tahun','TAHUN 2022')
@endif

@section('content')
    @if (request('isTransfer'))
        @foreach (getMonthsYear() as $month)
            <span>{{ $month }}</span>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="align-middle text-center">
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @forelse (getPendapatan($month, true) as $transfer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transfer->created_at->format('d/m/y') }}</td>
                                <td>{{ $transfer->keterangan }}</td>
                                <td class="text-end">{{ number_format($transfer->jumlah,0) }}</td>
                                @php
                                    $total = $total + $transfer->jumlah;
                                @endphp
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <p>Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">Total</th>
                            <th class="text-end">{{ number_format($total,0) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
        @elseif (request('pendapatanLain'))
            @foreach ($jenis_pendapatans as $jenis_pendapatan)
                <span>{{ $jenis_pendapatan->nama }}</span>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="align-middle text-center">
                                <th rowspan="2">No.</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Keterangan</th>
                                <th colspan="2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @forelse ($pendapatans as $pendapatan)
                                @if ($pendapatan->jenis_pendapatan_id == $jenis_pendapatan->id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pendapatan->created_at->format('d/m/y') }}</td>
                                        <td>{{ $pendapatan->keterangan }}</td>
                                        <td class="text-end">{{ number_format($pendapatan->jumlah,0) }}</td>
                                        @php
                                            $total = $total + $pendapatan->jumlah;
                                        @endphp
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Tidak ada data</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center">Total</th>
                                <th class="text-end">{{ number_format($total,0) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endforeach
        @else 
        @foreach (getMonthsYear() as $month)
            <span>{{ $month }}</span>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="align-middle text-center">
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Tanggal</th>
                            <th rowspan="2">Keterangan</th>
                            <th colspan="2">Pendapatan</th>
                        </tr>
                        <tr>
                            <th class="text-center">Cash</th>
                            <th class="text-center">Trf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cash = 0;
                            $trf = 0;
                        @endphp
                        @forelse (getPendapatan($month) as $pendapatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pendapatan->created_at->format('d/m/y') }}</td>
                                <td>{{ $pendapatan->keterangan }}</td>
                                @if ($pendapatan->isTransfer == true)
                                    <td></td>
                                    <td class="text-end">{{ number_format($pendapatan->jumlah,0) }}</td>
                                    @php
                                        $trf = $trf + $pendapatan->jumlah;
                                    @endphp

                                @else
                                    <td class="text-end">{{ number_format($pendapatan->jumlah,0) }}</td>
                                    <td></td>
                                    @php
                                        $cash = $cash + $pendapatan->jumlah;
                                    @endphp
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <p>Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">Total</th>
                            <th class="text-end">{{ number_format($cash,0) }}</th>
                            <th class="text-end">{{ number_format($trf,0) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach
    @endif
    <script type="text/javascript">
        window.print();
    </script>

@endsection

