@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Tambah Petugas</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-body">
                            <form method="POST" action="{{ route('petugas.store') }}">
                                @csrf
                                <div class="auth-credentials">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="level" class="form-label">Level</label>
                                            <input type="text" class="form-control m-b-md" name="level" id="level" aria-describedby="level" value="petugas" readonly>
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
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="banjar" class="form-label">Banjar</label>
                                            <select class="form-select m-b-md @error('banjar') is-invalid @enderror" id="banjar" name="banjar_id" required>
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
                                            <label for="telp" class="form-label">Telp</label>
                                            <input type="text" class="form-control m-b-md @error('telp') is-invalid @enderror" name="telp" id="telp" aria-describedby="telp" value="{{ old('telp') }}" required autocomplete="telp" >
                                            @error('telp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="username" id="username_label" class="form-label">Username</label>
                                            <input type="text" class="form-control m-b-md @error('username') is-invalid @enderror" name="username" id="username" aria-describedby="username" required autocomplete="username" >
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" id="password" aria-describedby="password" required autocomplete="new-password">
                                            @error('password')
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

@endsection