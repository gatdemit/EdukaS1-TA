@extends('layouts.main')

@section('container')
    <div class="row mt-5">
        <div class="col-lg-5">
            @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <main class="form-registration p-5 w-100 m-auto">
                <div class="container p-5 border border-1" style="box-shadow: 10px 10px 25px;">
                    <h1 class="text-center" style="font-weight: 800;">Registration</h1>
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
                            <label for="password" class="form-control-label">Password</label>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password_confirmation" id="password" placeholder="passcon" value="{{ old('passcon') }}" class="form-control @error('password') is-invalid @enderror" required>
                            <label for="password" class="form-control-label">Ulangi Password</label>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary w-100 mb-3 bold" type="submit">Sign Up</button>
                        <p class="text-center">Already have an account? <a href="/login" class="text-decoration-none">Login</a></p>
                    </form>
                </div>
            </main>
        </div>
        <div class="col-md-7 text-center">
            <img src="{{ asset('storage/asset/registration.jpeg') }}" alt="" class="mb-3">
            <p class="text-start display-6" style="font-size: 24px;">Dengan Mendaftarkan Akun Di Edukas1, Anda Akan
                Mendapatkan Akses Eksklusif Ke Beragam Kursus Berkualitas, Materi Pendukung, Dan Pengalaman Pembelajaran Yang
                Disesuaikan Dengan Kebutuhan Anda.
            </p>
        </div>
    </div>
    @endsection