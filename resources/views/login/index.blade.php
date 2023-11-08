@extends('layouts.main')

@section('container')
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
        <main class="form-signin w-100 m-auto">
            <form action="/login" method="post">
                @csrf
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
                    <input type="password" name="password" id="password" placeholder="password" value="{{ old('password') }}" class="form-control" required>
                    <label for="password" class="form-control-label @error('password') is-invalid @enderror">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="btn btn-primary" type="submit">Login</button>
            </form>
            Lupa Password? <a href="/forgotpass">Reset Passwordmu!</a><br>
            Daftar <a href="/register">di sini!</a>
        </main>
    </div>
@endsection
