@if(Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profile']=="fill")
    {{ abort(403); }}
@else
    @extends('dashboard.layouts.main')

    @section('container')
        <style>
            .parent::before {
                position: absolute;
                top: 0px;
                right: 0px;
                bottom: 0px;
                left: 0px;
                opacity: 0.4;
                content: "";
                z-index: -1;
                background-image: url('{{ asset("storage/asset/Login.jpeg") }}');
                background-size: 600px 300px;
                background-repeat: repeat;
                background-position: center center;
            }
        
            .parent {
                box-shadow: 0px -1px 99px 20px rgba(255, 255, 255, 0.79) inset;
                -webkit-box-shadow: 0px -1px 99px 20px rgba(255, 255, 255, 0.79) inset;
                -moz-box-shadow: 0px -1px 99px 20px rgba(255, 255, 255, 0.79) inset;
                height: 90vh;
                position: relative;
            }
        </style>
        <div class="parent">
            <div class="form-signin p-5 m-auto col-md-6 col-sm-12">
                <div class="container p-5 border border-1" style="box-shadow: 10px 10px 25px; background-color: #fff">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h1 style="color: #0038CF; font-weight: 600;">Buat Profilmu!</h1>
                    <h3 style="color: #0038CF; font-weight: 600;">Avatarmu</h3>
                    <form action="/dashboard/create" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-floating mb-3 t d-flex justify-content-between thumbnail">
                                <div class="row align-items-center">
                                    <span class="col me-3">
                                        <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" class="img-preview" style="border-radius: 50%; height:120px; width:120px; max-height:120px; max-width:120px;" role="button" id="myfile" name="myfile">
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage();" style="display:none;" accept="image/*">
                                        @error('image') 
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </span>
                                    <div class="col" style="text-align: center;" role="button" class="caption" id="other" name="other">
                                        <i class="bi bi-camera-fill"></i>
                                        <p>Tambah Foto</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" id="name" placeholder="Nama" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
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
                                        <select class="form-select" id="floatingSelectGrid" name="gender" required>
                                            <option disabled>--Jenis Kelamin--</option>
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                        <label for="floatingSelectGrid">Jenis Kelamin</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                                        <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="phone-number" id="phone-number" placeholder="Nomor Telepon" value="{{ old('phone-number') }}" class="form-control @error('phone-number') is-invalid @enderror" required>
                                        <label for="phone-number" class="form-control-label">Nomor Telepon</label>
                                        @error('phone-number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea name="address" id="address" placeholder="Alamat" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" required></textarea>
                                    <label for="address" class="form-control-label">Alamat</label>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
                            </div>
                        <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                    </form>
                </div>
            </div>
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

                imgPreview.style.display = "inline-block";

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);
                oFReader.onload = function(oFREvent){
                    imgPreview.src = oFREvent.target.result;
                };
            }
        </script>
    @endsection
@endif
