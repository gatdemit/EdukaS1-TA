@extends('dashboard.layouts.main')

@section('container-header')
    <h1>Manage your account!</h1>
@endsection

@section('container-top')

<div class="align-items-center border bg-body-tertiary px-1 py-3 mb-3">
    <div class="my-0">
        <div class="container">
            @if(session()->has('error'))
                <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5>Change your password!</h5>
            <form action="/dashboard/account" method='post'>
                @csrf
                <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                <div class="form-floating mb-3">
                    <input type="password" name="oldpassword" id="oldpassword" placeholder="oldpassword" value="{{ old('oldpassword') }}" class="form-control @error('oldpassword') is-invalid @enderror" required autofocus>
                    <label for="oldpassword" class="form-control-label">Old Password</label>
                    @error('oldpassword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" placeholder="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required autofocus>
                    <label for="password" class="form-control-label">New Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password_confirmation" id="password" placeholder="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required autofocus>
                    <label for="password" class="form-control-label">Confirm New Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('container-main')
<div class="align-items-center border bg-body-tertiary px-1 py-3 mb-3">
    <div class="my-0">
        <div class="container">
            @if(session()->has('delError'))
                <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                    {{ session('delError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5>Delete Your Account!</h5>
            <form action="/dashboard/{{ Session::get('email') }}" method="post">
                @method('delete')
                @csrf
                <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                <button class="btn btn-danger" onclick="return confirm('are you sure?')">Delete Account</button>
            </form>
        </div>
    </div>
</div>

@endsection