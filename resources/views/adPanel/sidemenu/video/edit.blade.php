@extends('adPanel.layouts.main')

@section('container')
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="/adPanel/video/{{ request()->segment(count(request()->segments())-1) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
                <div class="form-floating mb-3">
                    <input type="text" name="judul" id="judul" placeholder="judul" value="{{ old('judul', Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Judul_Video']) }}" class="form-control @error('judul') is-invalid @enderror" required autofocus>
                    <label for="judul" class="form-control-label">Judul Video</label>
                    @error('judul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="harga" id="harga" placeholder="harga" value="{{ old('harga', Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Harga']) }}" class="form-control @error('harga') is-invalid @enderror" required>
                    <label for="harga" class="form-control-label">Harga</label>
                    @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <label for="deskripsi" class="form-control-label">Deskripsi Video</label>
                <div class="form-group mb-3">
                    <textarea name="deskripsi" id="deskripsi" placeholder="deskripsi" value="{{ old('deskripsi') }}" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Deskripsi'] }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
            <input type="hidden" name="fakultas" id="fakultas" value="{{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Fakultas'] }}">
            <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Jurusan']) }}">
            <input type="hidden" name="video" id="video" value="{{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Video'] }}">
            <input type="hidden" name="email" id="email" value="{{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Email_Dosen'] }}">
        </form>
@endsection