@extends('layout.auth.core')

@section('content')


<div class="app horizontal-menu app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-evenlyS">
    
    <div class="app-auth-container">
        <div class="logo">
            <a href="/home">CUB Ungasan</a>
        </div>

        <form method="POST" action="{{ route('postLoginUser') }}">
            @csrf
            <div class="auth-credentials">
                <label for="username" class="form-label">Username</label>
                <input type="username" class="form-control m-b-md @error('username') is-invalid @enderror" name="username" id="username" aria-describedby="username" value="{{ old('username') }}" required autocomplete="username">
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" aria-describedby="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="auth-submit mt-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('Masuk') }}
                </button>
            </div>
        </form>

        <p class="auth-description">Belum melakukan pendaftaran? 
            <a href="{{ route('getRegistrasi') }}">Registrasi</a>
        </p>
        
    </div>
    {{-- <div class="app-auth-background"></div> --}}
</div>

@if(session()->has('status'))
    @include('layout.backend.alert')
@endif

@endsection
