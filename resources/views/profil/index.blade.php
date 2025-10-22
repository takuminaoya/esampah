@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Profil</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{  $user->nama  }}</td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>: {{  $user->nik  }}</td>
                                </tr>
                                <tr>
                                    <td>Banjar</td>
                                    <td>: {{  $user->banjar->nama  }}</td>
                                </tr>
                                <tr>
                                    <td>Telp</td>
                                    <td>: {{ $user->telp }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{  $user->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $user->email }}</td>
                                </tr>
                                @if (auth()->user()->level == 'false')
                                    <tr>
                                        <td>Kategori</td>
                                        <td>: {{ $user->distributionCode->objek }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Usaha</td>
                                        <td>: {{  $user->usaha }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Daftar</td>
                                        <td>: {{ $user->created_at->format('d-m-Y') }}</td>
                                    </tr>
                                @endif 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editpass{{ $user->id }}">
                            Ubah Password
                         </button>
                        <div class="modal fade" id="editpass{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Ubah Password</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form method="post" action="{{route('profil.editpass')}}">
                                        @method('patch')
                                        @csrf
                                            <div class="form-group mt-2">
                                                <label for="password_lama">Password Lama</label>
                                                <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama" >
                                                @error('password_lama')
                                                    <div class="invalid-feedback">
                                                    {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password_baru">Password Baru</label>
                                                <input type="password" class="form-control @error('password_baru') is-invalid @enderror" id="password_baru" name="password_baru" >
                                                @error('password_baru')
                                                    <div class="invalid-feedback">
                                                    {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <label for="konfirmasi">Konfirmasi Password</label>
                                                <input type="password" class="form-control @error('konfirmasi') is-invalid @enderror" id="konfirmasi" name="konfirmasi">
                                                @error('konfirmasi')
                                                    <div class="invalid-feedback">
                                                    {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-4"> 
                                                <button type="submit" class="btn btn-primary">Simpan </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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