@extends('adPanel.layouts.main')

@section('container')
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="/adPanel/fakultas" method="post">
            @csrf
            <div class= "row" >
                <div class="col" id="parentbody">
                    <div class="form-floating mb-3">
                        <input type="text" name="fakultas" id="fakultas" class="form-control" required></input>
                        <label for="pertanyaan" class="form-control-label">Fakultas</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="jurusan1" id="jurusan1" class="form-control" required></input><label for="jurusan1" class="form-control-label">Jurusan 1</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="deskripsi1" id="deskripsi1" class="form-control" required></input><label for="deskripsi1" class="form-control-label">Deskripsi 1</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="#" class="btn btn-outline-success" onclick=addRow() style="font-weight: 500;">Tambah Jurusan</a>
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
            `
            <div class="form-floating mb-2">
                <input type='text' name='jurusan${count+1}' id='jurusan${count+1}' class='form-control' required><label for="jurusan${count+1}" class="form-control-label">Jurusan ${count+1}</label>
            </div>
            <div class="form-floating mb-3">
                <input type='text' name='deskripsi${count+1}' id='deskripsi${count+1}' class='form-control' required><label for="deskripsi${count+1}" class="form-control-label">Deskripsi ${count+1}</label>
            </div>
            `
            +
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection