@extends('layouts.main')

@section('container')
    <div class="col-md-5">
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <main class="form-signin w-100 m-auto">
            <form action="/forgotpass" method="post">
                @csrf
                <div class="form-floating">
                    <input type="email" name="email" id="email" placeholder="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                    <label for="email" class="form-control-label">Email</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </main>
    </div>
@endsection