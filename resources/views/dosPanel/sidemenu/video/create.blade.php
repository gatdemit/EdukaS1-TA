@extends('dosPanel.layouts.main')

@section('container')

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="/dosPanel/video" method="post" enctype="multipart/form-data">
            @csrf
                <label for="video">Upload Video (max: 5 MB)</label>
                <div class="input-group mb-3">
                    <input class="form-control @error('video') is-invalid @enderror" accept="video/*" type="file" id="video" name="video" required>
                    @error('video') 
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="judul" id="judul" placeholder="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" required autofocus>
                    <label for="judul" class="form-control-label">Judul Video</label>
                    @error('judul')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="fakultas" name="fakultas" onchange="return showcategory();" required>
                        <option selected disabled>--Fakultas--</option>
                        @foreach($faks as $fakultas)
                            @if(count($fakultas) <= 3)
                                <option value="{{ $fakultas['Value'] }}">{{ $fakultas['Value'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="fakultas">Fakultas</label>
                </div>
                <div class="form-floating mb-3" id="divJur">
                    <select class="form-select" name="jurusan" id="jurusan" required>
                        <option selected disabled>--Jurusan--</option>
                        @foreach($faks as $fakultas)
                            @if(count($fakultas) <= 3)
                                <optgroup label ="{{ $fakultas['Value'] }}" id="{{ $fakultas['Value'] }}" style="display:none;">
                                    @foreach($fakultas['jurusan'] as $jurusan)
                                        <option value="{{ $jurusan['Value'] }}">{{ $jurusan['Value'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                    <label for="jurusan">Jurusan</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="harga" id="harga" placeholder="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" required>
                    <label for="harga" class="form-control-label">Harga</label>
                    @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <textarea name="deskripsi" id="deskripsi" placeholder="deskripsi" value="{{ old('deskripsi') }}" class="form-control @error('deskripsi') is-invalid @enderror" required></textarea>
                    <label for="deskripsi" class="form-control-label">Deskripsi Video</label>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
        </form>
    <script>
        var divJurusan = document.getElementById('divJur').getElementsByTagName('optgroup');
        
        function showcategory(){
        var selectBox = document.getElementById('fakultas');
        var userInput = selectBox.options[selectBox.selectedIndex].value;
        var jurusanSelect = document.getElementById(userInput);
        for($m=0; $m < selectBox.options.length-1; $m++){
            if(divJurusan[$m].id == userInput){
                divJurusan[$m].style.display = '';
            } else{
                divJurusan[$m].style.display = 'none';
            }
        }
    }
    </script>
@endsection