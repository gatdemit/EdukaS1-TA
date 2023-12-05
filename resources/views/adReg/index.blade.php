<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    {{-- Booststrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- My CSS --}}
    <link href="/css/style.css" rel="stylesheet">
    
    <title>{{ $title }}</title>
</head>
<body>
    <div class="row mt-5 justify-content-center">
        <div class="col-lg-5">
            @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <main class="form-registration p-5 w-100 m-auto">
                <div class="container p-5 border border-1">
                    <h1 class="text-center">Pembuatan Akun Admin</h1>
                <form action="/adReg" method="post">
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
                    <button class="btn btn-primary w-100 mb-3" type="submit">Create</button>
                    <a href="/adPanel">Back to Admin Panel</a>
                </form>
            </main>
        </div>
    </div>
</body>