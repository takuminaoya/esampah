@extends('layout.auth.core')

@section('content')


<div class="app horizontal-menu app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-evenly">
<div class="col-12 mt-2 pe-2 ps-2">
</div>
    <div class="col-lg-6 col-sm-12 p-3">
        <div class="card text-left">
            <div class="card-body">
                <h3 class="card-title text-center">Periksa Status Pendaftaran</h3>
                <img src="{{ asset('images/backgrounds/login.svg') }}" class="gambar mt-5 mb-5" alt="">
                <p>Periksa status pendaftaran untuk masuk ke akun Anda</p>
                <form method="post" action="{{ route('checkVerifikasi') }}">
                    @csrf
                    <input type="text" class="form-control m-b-md @error('check') is-invalid @enderror" name="check" id="check" aria-describedby="check" value="{{ old('check') }}" required autocomplete="check" placeholder="Masukkan NIK">
                    @error('check')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <button type="submit" class="btn btn-outline-primary">Periksa</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-12 p-3">
        <div class="card">
            <div class="card-body">
                <div class="registrasi mb-3">
                    <div class="logo">
                        <a href="{{ url('/home') }}">CUB Ungasan</a>
                    </div>
                </div>
                <form method="POST" action="{{ route('postRegistrasi') }}">
                    @csrf
                    <div class="auth-credentials">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control m-b-md @error('nik') is-invalid @enderror" name="nik" id="nik" aria-describedby="nik" oninput="getNIK(this.value)" value="{{ old('nik') }}">
                                @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="nama" id="nama_label" class="form-label">Nama</label>
                                <input type="text" class="form-control m-b-md @error('nama') is-invalid @enderror" name="nama" id="nama" aria-describedby="nama" value="{{ old('nama') }}">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12" id="kategori_label">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select m-b-md @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
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
                            <div class="col-lg-6 col-sm-12" style="display: none" id="nama_usaha_label">
                                <label for="nama_usaha" class="form-label">Nama Usaha</label>
                                <input type="text" class="form-control m-b-md @error('nama_usaha') is-invalid @enderror" name="nama_usaha" id="nama_usaha" aria-describedby="nama_usaha" value="{{ old('nama_usaha') }}">
                                @error('nama_usaha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control m-b-md @error('alamat') is-invalid @enderror" name="alamat" id="alamat" aria-describedby="alamat" value="{{ old('alamat') }}" required autocomplete="alamat" >
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-sm-12">
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
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="username" class="form-label">Username</label>
                                <input type="username" class="form-control m-b-md @error('username') is-invalid @enderror" name="username" id="username" aria-describedby="username" value="{{ old('username') }}" required autocomplete="username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="telp" class="form-label">Telp</label>
                                <input type="text" class="form-control m-b-md @error('telp') is-invalid @enderror" name="telp" id="telp" aria-describedby="telp" value="{{ old('telp') }}" required autocomplete="telp" >
                                @error('telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" aria-describedby="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                            <div class="col-lg-6 col-sm-12">
                                <label for="password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required autocomplete="new-password">
                            </div>
                        </div>
                    <div class="auth-submit mt-5">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Registrasi') }}
                        </button>
                    </div>
                </form>
                <p class="auth-description mt-2 text-center">Sudah memiliki akun? 
                    <a href="{{ route('getLoginUser') }}">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('#kategori').on('change', function(){
        let tes = $('#kategori').val();
        $.get("{{ route('getKodeDistribusi') }}", function(distribusis){
            $.each(distribusis, function(i,distribusi){
                if(tes == distribusi.id){
                    if(distribusi.kategori == '1'){
                        $('#nama_usaha_label').hide();
                        $('#kategori_label').removeClass('col-lg-6');
                        $('#kategori_label').addClass('col-lg-12');
                    }
                    else{
                        $('#nama_usaha_label').show();
                        $('#kategori_label').removeClass('col-lg-12');
                        $('#kategori_label').addClass('col-lg-6');
                    }
                }
            });
        });
    })
    


    function getNIK(nik){
        $.ajax({
            type: "GET",
            url: "https://ungasan.silagas.id/api/penduduk/nik/" + nik,
            data: {
                "token" : "{{ env('TOKEN_API') }}"
            },
            success: function(response){
                if(response['data'] != null){
                    $('#nama').val(response['data']['nama_lengkap']);
                    $('#alamat').val(response['data']['alamat']);
                    let banjars = $('#banjar').find('option');
                    $.each(banjars, function(i, banjar){
                       if(banjars.eq(i).text() == response['data']['dusun']){
                            banjars.eq(i).prop('selected',true);
                        } 
                    });
                }
                else{
                    $.ajax({
                        type: "GET",
                        url: "https://ungasan.silagas.id/api/penduduk/np/" + nik "?" ,
                        data: {
                            "token" : "{{ env('TOKEN_API') }}"
                        },

                        success: function(response){
                            if(response['data'] != null){
                                $('#nama').val(response['data']['nama_lengkap']);
                                $('#alamat').val(response['data']['alamat']);
                                let banjars = $('#banjar').find('option');
                                $.each(banjars, function(i, banjar){
                                if(banjars.eq(i).text() == response['data']['dusun']){
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
            }
        });
    }
</script>

@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@endsection
