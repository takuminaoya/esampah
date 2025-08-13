@extends('layout.backend.cetak')

@section('judul','DATA PELANGGAN CIPTA UNGASAN BERSIH')
@section('tahun','TAHUN 2022')

@section('content') 
<body>    
    <div class="table-responsive-lg">
        @if (Auth::user()->level == 'admin' || Auth::user()->level == 'bendahara')
            <table class="table table-bordered">
                <thead>
                    <tr class="align-middle">
                        <th rowspan="3">No.</th>
                        <th rowspan="3">Nama</th>
                        <th rowspan="3">Nama Usaha</th>
                        <th rowspan="3">Alamat</th>
                        <th rowspan="3">Wilayah</th>
                        <th rowspan="3">No Telp</th>
                        <th rowspan="3">Group</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <tr>
                            <td>{{  $loop->iteration  }}</td>
                            <td>{{  $pelanggan->nama  }}</td>
                            <td>{{ $pelanggan->usaha }}</td>
                            <td>{{  $pelanggan->alamat }}</td>
                            <td>BR. {{ $pelanggan->banjar->nama }}</td>
                            <td>{{ $pelanggan->telp }}</td>
                            <td>{{ getJalur($pelanggan->id)}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <p>Tidak ada data</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
    <script type="text/javascript">
        window.print();
    </script>
@endsection

