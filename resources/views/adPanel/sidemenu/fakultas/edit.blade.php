@extends('adPanel.layouts.main')

@section('container')
        <h4 style="color: #0038CF; font-weight: 500;">Fakultas {{ Str::replace('_', ' ', request()->segment(count(request()->segments())-1)) }}</h4>
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class= "row" action="/adPanel/fakultas/{{ request()->segment(count(request()->segments())-1) }}" method="post">
            @method('put')
            @csrf
            <input type="hidden" name="fakultas" id="fakultas" value="{{ request()->segment(count(request()->segments())-1) }}">
            <input type="hidden" name="childCount" id="childCount" value="{{ Firebase::database()->getReference('faculties/' . request()->segment(count(request()->segments())-1). '/jurusan')->getSnapshot()->numChildren() }}">
            <div class="col">
                <div id="parentbody">
                    <div class="form-floating mb-3">
                        <input type="text" name="jurusan1" id="jurusan1" class="form-control" required autofocus>
                        <label for="jurusan1" class="form-control-label">Jurusan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="deskripsi1" id="deskripsi1" class="form-control" required>
                        <label for="deskripsi1" class="form-control-label">Deskripsi</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="#" class="btn btn-outline-success" onclick=addRow() style="text-decoration:none; text-color:white; font-weight: 500;">Tambah</a>
                    <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
                </div>
            </div>
        </form>

    <script>
        var parBody = document.getElementById('parentbody');

        var count = 0;

        function addRow()
        {
            count++

            var tr = 
            `<div class='form-floating mb-3'><input type='text' name='jurusan${count+1}' id='jurusan${count+1}' class='form-control' required><label for="jurusan${count+1}" class="form-control-label">Jurusan</label></div><div class='form-floating mb-3'><input type='text' name='deskripsi${count+1}' id='deskripsi${count+1}' class='form-control' required><label for="deskripsi${count+1}" class="form-control-label">Deskripsi</label></div>`+
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection