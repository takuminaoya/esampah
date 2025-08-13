@extends('layout.backend.cetak')

@section('judul','DATA SETORAN CIPTA UNGASAN BERSIH')
@section('tahun','TAHUN 2022')

@section('content') 
    <div class="table-responsive-lg">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Bulan</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setorans as $setoran)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td scope="row">1/{{$setoran->month}}/{{ Carbon\Carbon::today()->year }}</td>
                    <td scope="row">Setoran ke bendahara</td>
                    <td scope="row">{{ number_format($setoran->biaya,0) }}</td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
@endsection


