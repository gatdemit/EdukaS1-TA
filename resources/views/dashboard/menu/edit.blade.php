@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-4">
    <div class="card-body">
        <h1 style="color: #0038CF; font-weight: 600;">Sunting Profilmu!</h1>
        <form action="/dashboard/{{ Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['username'] }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
                <div class="form-floating mb-3 t d-flex justify-content-between thumbnail">
                    <div>
                        <span class="d-inline-block me-3">
                            <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" class="img-preview" style="border-radius: 50%; height:120px; width:120px; max-height:120px; max-width:120px;" role="button" id="myfile" name="myfile">
                            <div role="button" class="caption" id="other" name="other">
                                <i class="bi bi-camera-fill"></i>
                                <p style="margin-top:-8px;">Tambah Foto</p>
                            </div>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage();" style="display:none;" accept="image/*">
                            @error('image') 
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </span>
                        <span class="d-inline-block">
                            <h3 style="color: #0038CF; font-weight: 600;">Avatarmu</h3>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" id="name" placeholder="Nama" value="{{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['name'] }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
                            <label for="name" class="form-control-label">Nama</label>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mb-3">
                            <input type="text" name="phone-number" id="phone-number" placeholder="Nomor Telepon" value="{{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['nomor_telp'] }}" class="form-control @error('phone-number') is-invalid @enderror" required>
                            <label for="phone-number" class="form-control-label">Nomor Telepon</label>
                            @error('phone-number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" required>{{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['alamat'] }}</textarea>
                    <label for="address" class="form-control-label">Alamat</label>
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
            <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
        </form>
    </div>
    <script>
        $('#myfile').click(function(){
            $('#image').click()
        });

        $('#other').click(function(){
            $('#image').click()
        });

        function previewImage(){
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'inline-block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        };
    }
    </script>  
    </div>
@endsection
