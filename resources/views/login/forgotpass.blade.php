@extends('layouts.main')

@section('container')
    <div class="row mt-5">
        <div class="col-md-7 p-5 text-center" style="background-color: #D0DCFE;">
            <img src="{{ asset('storage/asset/forgot_pass.png') }}" alt="">
            <h1>Welcome To Edukas1</h1>
            <p class="display-6">Kami senang anda kembali! Masuk ke akun anda adalah pintu menuju pengalaman pendidikan anda yang lebih lanjut</p>
        </div>
        <div class="col-md-5" style="margin-top: 100px;">
            @if(session()->has('error'))
                <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="form-signin w-100 m-auto">
                <div class="container p-5">
                    <h1 class="text-center mb-5">Edukas<span class="text-primary">1</span></h1>
                    <h1>Forgot Password?</h1>
                    <p>Enter your email to reset your password.</p>
                    <form action="/forgotpass" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" placeholder="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                            <label for="email" class="form-control-label">Email</label>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary mb-3 w-100">Submit</button>
                        <a href="/login" class="text-decoration-none text-center d-block">Back To Login</a>
                    </form>
                </div>
        </div>
    </div>
@endsection