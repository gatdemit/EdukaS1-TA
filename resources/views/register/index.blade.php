@extends('layouts.main')

@section('container')
<style>
    .parent::before {
        position: absolute;
        top: 0px;
        right: 0px;
        bottom: 0px;
        left: 0px;
        opacity: 0.2;
        content: "";
        z-index: -1;
        background-image: url('{{ asset("storage/asset/registration.jpeg") }}');
        background-size: 600px 300px;
        background-repeat: repeat;
        background-position: center center;
    }

    .parent {
        box-shadow: 0px -1px 99px 20px rgba(255, 255, 255, 0.79) inset;
        -webkit-box-shadow: 0px -1px 99px 20px rgba(255, 255, 255, 0.79) inset;
        -moz-box-shadow: 0px -1px 99px 20px rgba(255, 255, 255, 0.79) inset;
        height: 90vh;
        position: relative;
    }
</style>

<div class="row mt-5">
    <div class="row col parent">
        @if(session()->has('error'))
        <div class="alert alert-danger  alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <main class="form-registration p-5 m-auto col-md-6 col-sm-12">
            <div class="container p-5 border border-1" style="box-shadow: 10px 10px 25px; background-color:#fff;">
                <h1 class="text-center mb-5" style="font-weight: 800;">Pendaftaran</h1>
                <form action="/register" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" name="username" id="username" placeholder="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" required autofocus>
                        <label for="username" class="form-control-label">Username</label>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="email" id="email" placeholder="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                        <label for="email" class="form-control-label">Email</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" placeholder="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required>
                        <label for="password" class="form-control-label">Kata Sandi (minimal 6 karakter)</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" id="password" placeholder="passcon" value="{{ old('passcon') }}" class="form-control @error('password') is-invalid @enderror" required>
                        <label for="password" class="form-control-label">Ulangi Kata Sandi</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100 mb-3 bold" type="submit">Daftar</button>
                    <p class="text-center">Sudah punya akun? <a href="/login" class="text-decoration-none">Masuk</a></p>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection