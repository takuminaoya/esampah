@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Tambah Pelanggan</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-body">
                            <form method="POST" action="{{ route('pelanggan.store') }}">
                                @csrf
                                <div class="auth-credentials">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <select class="form-select m-b-md @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required autofocus>
                                                <option value="">--Pilih Kategori--</option>
                                                @foreach ($distribusis as $distribusi)
                                                    <option value="{{ $distribusi->id }}">{{ $distribusi->objek }}</option>
                                                @endforeach
                                            </select>
                                            @error('kategori')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="nik" class="form-label">NIK</label>
                                            <input type="text" class="form-control m-b-md @error('nik') is-invalid @enderror" name="nik" id="nik" aria-describedby="nik" oninput="getNIK(this.value)" value="{{ old('nik') }}" required autocomplete="nik">
                                            @error('nik')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="nama" id="nama_label" class="form-label">Nama</label>
                                            <input type="text" class="form-control m-b-md @error('nama') is-invalid @enderror" name="nama" id="nama" aria-describedby="nama" value="{{ old('nama') }}" required autocomplete="nama" >
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                   
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" class="form-control m-b-md @error('alamat') is-invalid @enderror" name="alamat" id="alamat" aria-describedby="alamat" value="{{ old('alamat') }}" required autocomplete="alamat" >
                                            @error('alamat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12" style="display: none" id="nama_usaha_label">
                                            <label for="nama_usaha" class="form-label">Nama Usaha</label>
                                            <input type="text" class="form-control m-b-md @error('nama_usaha') is-invalid @enderror" name="nama_usaha" id="nama_usaha" aria-describedby="nama_usaha" value="{{ old('nama_usaha') }}">
                                            @error('nama_usaha')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="banjar" class="form-label">Banjar</label>
                                            <select class="form-select m-b-md @error('banjar') is-invalid @enderror" id="banjar" name="banjar" required>
                                                <option value="">--Pilih Banjar--</option>
                                                @foreach ($banjars as $banjar)
                                                    <option value="{{ $banjar->sid }}">{{ $banjar->nama_banjar }}</option>
                                                @endforeach
                                            </select>
                                            @error('banjar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="telp" class="form-label">No. WA</label>
                                            <input type="text" class="form-control m-b-md @error('telp') is-invalid @enderror" name="telp" id="telp" aria-describedby="telp" value="{{ old('telp') }}" required autocomplete="telp" >
                                            @error('telp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="rekanan" class="form-label">Rekanan</label>
                                            <select class="form-select m-b-md @error('rekanan') is-invalid @enderror" id="rekanan" name="rekanan" required autofocus>
                                                @foreach ($rekanans as $rekanan)
                                                    <option value="{{ $rekanan->id }}">{{ $rekanan->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('rekanan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="biaya" class="form-label">Biaya</label>
                                            <input type="text" class="form-control m-b-md @error('biaya') is-invalid @enderror" name="biaya" id="biaya" aria-describedby="biaya" value="{{ old('biaya') }}" required autocomplete="biaya" >
                                            @error('biaya')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                <div class="auth-submit mt-5">
                                    <button type="submit" class="btn btn-primary ">
                                        {{ __('Submit') }}
                                    </button>
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
    $('#kategori').on('change', function(){
        let tes = $('#kategori').val();
        $.get("{{ route('getKodeDistribusi') }}", function(distribusis){
            $.each(distribusis, function(i,distribusi){
                if(tes == distribusi.id){
                    if(distribusi.kategori == '1'){
                        $('#nama_usaha_label').hide();
                    }
                    else{
                        $('#nama_usaha_label').show();
                    }
                }
            });
        });
    });
    
    function getNIK(nik){
        $.ajax({
            type: "GET",
            url: "https://desaungasan.badungkab.go.id/api/penduduk/" + nik,
            data: {
                "token" : "{{ env('TOKEN_API') }}"
            },
            success: function(response){
                if(response['tipe'] == 'p'){
                    $('#nama').val(response['data']['nama_lengkap']);
                    $('#alamat').val(response['data']['alamat']);
                    let banjars = $('#banjar').find('option');
                    $.each(banjars, function(i, banjar){
                        if(banjars.eq(i).text() == response['data']['dusun']){
                            banjars.eq(i).prop('selected',true);
                        } 
                    });
                }
                else if(response['tipe'] == 'np'){
                    $('#nama').val(response['data']['nama_lengkap']);
                    $('#alamat').val(response['data']['il_alamat']);
                    let banjars = $('#banjar').find('option');
                    $.each(banjars, function(i, banjar){
                        if(banjars.eq(i).text() == response['data']['il_dusun']){
                            banjars.eq(i).prop('selected',true);
                        } 
                    });
                }else{
                    $('#nama').val("");
                    $('#alamat').val("");
                    $('#banjar').val("");
                }
            }
        });
    }
</script>
@endsection