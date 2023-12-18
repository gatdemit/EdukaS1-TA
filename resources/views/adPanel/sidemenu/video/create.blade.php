@extends('adPanel.layouts.main')

@section('container')
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class="row" action="/adPanel/video" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-floating mb-3 text-center">
                    <input class="form-control @error('video') is-invalid @enderror" accept="video/*" type="file" id="video" name="video">
                    <label for="video" class="form-label">Upload Video (Max: 5 MB)</label>
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
                    <select class="form-select" id="fakultas" name="fakultas" onchange="return showcategory();">
                        <option selected disabled>--Fakultas--</option>
                        @foreach($faks as $fakultas)
                            <option value="{{ $fakultas['Value'] }}">{{ $fakultas['Value'] }}</option>
                        @endforeach
                    </select>
                    <label for="fakultas">Fakultas</label>
                </div>
                <div class="form-floating mb-3" id="divJur">
                    <select class="form-select" name="jurusan" id="jurusan">
                        <option selected disabled>--Jurusan--</option>
                        @foreach($faks as $fakultas)
                            <optgroup label ="{{ $fakultas['Value'] }}" id="{{ $fakultas['Value'] }}" style="display:none;">
                                @foreach($fakultas['jurusan'] as $jurusan)
                                    <option value="{{ $jurusan }}">{{ $jurusan }}</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        <label for="jurusan">Jurusan</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="harga" id="harga" placeholder="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" required autofocus>
                    <label for="harga" class="form-control-label">Harga</label>
                    @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <textarea name="deskripsi" id="deskripsi" placeholder="deskripsi" value="{{ old('deskripsi') }}" class="form-control @error('deskripsi') is-invalid @enderror" required autofocus></textarea>
                    <label for="deskripsi" class="form-control-label">Deskripsi Video</label>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="font-weight: 500; font-family: Raleway;">Submit</button>
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
        // var jurusanSelect$m = document.getElementById("fakultas");
        // console.log(jurusanSelect$m);
        // if (userInput == $jurusanSelect){
        // document.getElementById(array_keys($faks)[$m]).style.visibility = 'visible';
        // } else{
        // document.getElementById(array_keys($faks)[$m]).style.visibility = 'hidden';
        // }
        return true;
    }
    </script>
@endsection