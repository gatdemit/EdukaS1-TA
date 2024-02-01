@extends('adPanel.layouts.main')

@section('container')
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class= "row" action="/adPanel/fakultas" method="post">
            @csrf
            <div class="col">
                <div class="form-floating mb-3">
                    <textarea name="fakultas" id="fakultas" class="form-control" autofocus required></textarea>
                    <label for="pertanyaan" class="form-control-label">Fakultas</label>
                </div>
                <div id="parentbody">
                    <div class="form-check my-2">
                        <input type="text" name="jurusan1" id="jurusan1" placeholder="Jurusan" class="form-control" required>
                        <input type="text" name="deskripsi1" id="deskripsi1" placeholder="Deskripsi" class="form-control" required>
                    </div>
                </div>
            </div>
            <a href="#" class="btn btn-success mt-2" onclick=addRow() style="font-weight: 500;">Tambah</a>
            <button type="submit" class="btn btn-primary mt-3" style="font-weight: 500;">Submit</button>
        </form>

    <script>
        var parBody = document.getElementById('parentbody');

        var count = 0;

        function addRow()
        {
            count++

            var tr = 
            `<div class='form-check my-2'><input type='text' name='jurusan${count+1}' id='jurusan${count+1}' placeholder='Jurusan' class='form-control' required><input type='text' name='deskripsi${count+1}' id='deskripsi${count+1}' placeholder='Deskripsi' class='form-control' required></div>`+
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection