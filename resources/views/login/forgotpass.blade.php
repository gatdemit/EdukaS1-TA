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
        background-image: url('{{ asset("storage/asset/forgot_pass.jpeg") }}');
        background-size: 100px 50px;
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
<div class="row mt-5 d-flex justify-content-center parent">
    <div class="col-md-5 col-sm-12" style="margin-top: 100px;">
        @if(session()->has('error'))
        <div class="alert alert-danger  alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="form-signin m-auto">
            <div class="container p-5 border border-1" style="box-shadow: 10px 10px 25px; background-color: #fff">
                <h1 class="text-center mb-5" style="font-weight: 800">Lupa Kata Sandi?</h1>
                <p>Masukkan emailmu untuk mengatur ulang kata sandi.</p>
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
                    <a href="/login" class="text-decoration-none text-center d-block">Masuk ke akunmu</a>
                </form>
            </div>
        </div>
    </div>
    @endsection