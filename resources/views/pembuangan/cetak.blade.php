@extends('layout.backend.cetak')

@section('judul','REKAP PEMBUANGAN SAMPAH')
@section('tahun',Carbon\Carbon::today()->isoFormat('MMMM').' 2022')

@section('content') 
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Jumlah</th>
                            <th>Plat</th>
                            <th>Rekanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembuangans as $pembuangan)
                            <tr>
                                <td>{{ $pembuangan->tanggal }}</td>
                                <td>{{ $pembuangan->jumlah }}</td>
                                <td>{{ $pembuangan->kendaraan->plat }}</td>
                                <td>{{ $pembuangan->kendaraan->rekanan->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                    

                    {{-- <thead>
                        <tr class="align-middle">
                            <th>Tgl</th>
                            @foreach ($rekanans as $rekanan)
                                <th>{{ $rekanan->nama }}</th>
                            @endforeach
                            <th>Total</th>
                        </tr>
                        <tr>
                            @foreach($rekanans as $rekanan)
                                @foreach ($kendaraans as $key => $kendaraan)
                                    @if($kendaraan->rekanan_id == $rekanan->id )
                                        <th>{{ $kendaraan->plat  }}</th>
                                    @endif
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kendaraans as $key => $kendaraan)
                            @forelse ($pembuangans as $pembuangan)
                                @if($kendaraan->id == $pembuangan->kendaraan_id )
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($pembuangan->tanggal)->format('d/m/y') }}</td>
                                        <td>{{ $pembuangan->jumlah }}</td>
                                    </tr>
                                
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <p>Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot></tfoot> --}}
                </table>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Plat</th>
                                    @foreach ($kendaraans as $kendaraan)
                                        @foreach ($total as $tot)
                                            @if ($kendaraan->id == $tot->kendaraan_id)
                                                <th>{{ $kendaraan->plat }} ({{ $kendaraan->rekanan->nama }})</th>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th>Jumlah</th>
                                @foreach ($kendaraans as $kendaraan)
                                    @foreach ($total as $tot)
                                        @if ($kendaraan->id == $tot->kendaraan_id)
                                            <td>{{ $tot->jumlah}} x Rp 100.000 </td>
                                        @endif
                                    @endforeach
                                @endforeach
                                
                            </tr>
                            </tbody>
                            <tfoot>
                                <th>Total</th>
                                @foreach ($kendaraans as $kendaraan)
                                    @foreach ($total as $tot)
                                        @if ($kendaraan->id == $tot->kendaraan_id)
                                            <td>Rp {{ number_format($tot->total,0) }}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tfoot>

                        </table>
            </div>

                        
        
    <script type="text/javascript">
        window.print();
    </script>
@endsection

