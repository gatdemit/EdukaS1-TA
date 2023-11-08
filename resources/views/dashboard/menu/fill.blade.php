@if(Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profile']=="fill")
    {{ abort(403); }}
@else
    @extends('dashboard.layouts.main')

    @section('container-header')
        <h1>Create your profile!</h1>
    @endsection

    @section('container-main')
        <form class ="row" action="/dashboard" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col">
                <div class="form-floating mb-3 text-center thumbnail">
                    @if(session()->has('success'))
                        <div class="alert alert-success  alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <img src="http://via.placeholder.com/150x150" class="img-preview" style="border-radius: 50%; height:120px; width:120px; max-height:120px; max-width:120px;" role="button" id="myfile" name="myfile">
                    <div role="button" class="caption" id="other" name="other">
                        <i class="bi bi-camera-fill"></i>
                        <p style="margin-top:-8px;">Add Photo</p>
                    </div>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage();" style="display:none;">
                    @error('image') 
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="name" id="name" placeholder="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
                    <label for="name" class="form-control-label">Name</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectGrid" name="gender">
                    <option disabled selected>--Jenis Kelamin--</option>
                    <option value="pria">Pria</option>
                    <option value="wanita">Wanita</option>
                    </select>
                    <label for="floatingSelectGrid">Jenis Kelamin</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required autofocus>
                    <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone-number" id="phone-number" placeholder="phone-number" value="{{ old('phone-number') }}" class="form-control @error('phone-number') is-invalid @enderror" required autofocus>
                    <label for="phone-number" class="form-control-label">Phone Number</label>
                    @error('phone-number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <textarea name="address" id="address" placeholder="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" required autofocus></textarea>
                    <label for="address" class="form-control-label">Address</label>
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
        </form>
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

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent){
                imgPreview.src = oFREvent.target.result;
            };
        }
        </script>
    @endsection
@endif
