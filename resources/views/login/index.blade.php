@extends('layouts.main')

@section('container')
<div class="row mt-5">
    <div class="col-md-7 p-5 text-center">
        <img src="{{ asset('storage/asset/Login.jpeg') }}" alt="">
        <p class="text-start display-6 mt-5" style="font-size: 24px;">Kami senang anda kembali! Masuk ke akun anda adalah pintu menuju pengalaman pendidikan anda yang lebih lanjut.</p>
    </div>
    <div class="col-md-5">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('belumLogin'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('belumLogin') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="form-signin w-100 p-5 m-auto">
            <div class="container p-5 border border-1" style="box-shadow: 10px 10px 25px;">
                <h1 class="text-center mb-5" style="font-weight: 800;">Login</h1>
                <form action="/login" method="post">
                    @csrf
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
                        <input type="password" name="password" id="password" placeholder="password" value="{{ old('password') }}" class="form-control" required>
                        <label for="password" class="form-control-label @error('password') is-invalid @enderror">Password</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100 mb-5 bold" type="submit">Login</button>
                </form>
                <div class="text-center">
                    <p class="mb-3"><a href="/forgotpass">Forgot Password?</a><br></p>
                    <P>Belum Punya Akun? Daftar <a href="/register">di sini!</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
