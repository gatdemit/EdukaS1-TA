@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-4">
    <div class="card-body">
        <h1 style="color: #0038CF; font-weight: 700;">Kelola Akunmu!</h1>
        <div class="my-0">
            <div class="container">
                @if(session()->has('error'))
                    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h5 style="color: #0038CF; font-weight: 600;">Ubah Kata Sandi</h5>
                <form action="/dashboard/account" method='post'>
                    @csrf
                    <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                    <div class="form-floating mb-3">
                        <input type="password" name="oldpassword" id="oldpassword" placeholder="oldpassword" value="{{ old('oldpassword') }}" class="form-control @error('oldpassword') is-invalid @enderror" required autofocus>
                        <label for="oldpassword" class="form-control-label">Kata Sandi Lama</label>
                        @error('oldpassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" placeholder="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required autofocus>
                        <label for="password" class="form-control-label">Kata Sandi Baru</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" id="password" placeholder="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" required autofocus>
                        <label for="password" class="form-control-label">Konfirmasi Kata Sandi Baru</label>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary" style="font-weight: 700;">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="align-items-center border bg-body-tertiary px-1 py-3 mb-3">
        <div class="my-0">
            <div class="container">
                @if(session()->has('delError'))
                    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                        {{ session('delError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h5 style="color: #0038CF; font-weight: 600;">Hapus Akunmu</h5>
                <p>Jika Anda menghapus akun Anda, maka Anda akan kehilangan akses terhadap video-video yang telah Anda beli secara permanen.</p>
                <form action="/dashboard/{{ Session::get('email') }}" method="post">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                    <button class="btn btn-outline-danger" onclick="return confirm('are you sure?')" style="font-weight: 500;">Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection