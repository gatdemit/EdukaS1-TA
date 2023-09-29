@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <main class="form-registration w-100 m-auto">
                <form action="/register" method="post">
                    @csrf
                    <div class="form-floating">
                        <input type="text" name="username" id="username" placeholder="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" required autofocus>
                        <label for="username" class="form-control-label">Username</label>
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="text" name="email" id="email" placeholder="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                        <label for="email" class="form-control-label">Email</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" id="password" placeholder="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required>
                        <label for="password" class="form-control-label">Password</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password_confirmation" id="password" placeholder="passcon" value="{{ old('passcon') }}" class="form-control @error('password') is-invalid @enderror" required>
                        <label for="password" class="form-control-label">Ulangi Password</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-control-input" name="tnc" id="tnc">
                        <label for="tnc" class="form-control-label">I have Read and Agreed to EdukaS1's User Terms & Agreements</label>
                    </div>
                    <button class="btn btn-primary" type="submit">Sign Up</button>
                </form>
            </main>
        </div>
    </div>
    @endsection