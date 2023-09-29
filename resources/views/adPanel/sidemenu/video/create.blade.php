@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Video</h1>
@endsection

@section('container')
    <div class="table-responsive col-lg-8">
        <form class= "row" action="/adPanel/video" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col">
                <div class="form-floating mb-3 text-center">
                    <input class="form-control @error('video') is-invalid @enderror" accept="video/*" type="file" id="video" name="video">
                    <label for="video" class="form-label">Upload Video</label>
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
                        @for($i=0; $i< count($faks); $i++)
                            <option value="{{ array_keys($faks)[$i] }}">{{ array_keys($faks)[$i] }}</option>
                        @endfor
                    </select>
                    <label for="fakultas">Fakultas</label>
                </div>
                <div class="form-floating mb-3" id="divJur">
                    <select class="form-select" name="jurusan">
                        <option selected disabled>--Jurusan--</option>
                    @for($k=0; $k< count($faks); $k++)
                    <optgroup label ="{{ array_keys($faks)[$k] }}" id="{{ array_keys($faks)[$k] }}" style="display:none;">
                        @for($l=0; $l< count($faks[array_keys($faks)[$k]]); $l++)
                            <option value="{{ $faks[array_keys($faks)[$k]][$l] }}">{{ $faks[array_keys($faks)[$k]][$l] }}</option>
                        @endfor
                        <label for="{{ array_keys($faks)[$k] }}">Jurusan</label>
                    </optgroup>
                        @endfor
                    </select>
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
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <textarea name="deskripsi" id="deskripsi" placeholder="deskripsi" value="{{ old('deskripsi') }}" class="form-control @error('deskripsi') is-invalid @enderror" required autofocus></textarea>
                    <label for="deskripsi" class="form-control-label">Deskripsi Video</label>
                    @error('deskripsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
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