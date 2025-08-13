@extends('layout.backend.core')

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Edit Data</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card widget widget-popular-blog">
                        <div class="card-body">
                            <form action="{{ route('kode-distribusi.update',$kodeDistribusi->id) }}" method="post">
                                @method('patch')
                                @csrf
                                <div class="row mb-3">
                                    <label for="objek" class="col-sm-2 col-form-label">Objek</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('objek') is-invalid @enderror" id="objek" name="objek" value="{{ $kodeDistribusi->objek }}">
                                        @error('objek')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ $kodeDistribusi->kode }}">
                                        @error('kode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                            <option value="1" {{ ($kodeDistribusi->kategori == '1') ? 'selected' : '' }}>Pribadi</option>
                                            <option value="2" {{ ($kodeDistribusi->kategori == '2') ? 'selected' : '' }}>Usaha</option>
                                        </select>
                                        @error('kategori')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ $kodeDistribusi->jumlah }}">
                                        @error('jumlah')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-end">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection