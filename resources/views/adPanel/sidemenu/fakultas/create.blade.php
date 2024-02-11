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
                    <input name="fakultas" id="fakultas" class="form-control" autofocus required></input>
                    <label for="pertanyaan" class="form-control-label">Fakultas</label>
                </div>
                <a href="#" class="btn btn-outline-success" onclick=addRow() style="font-weight: 500;">Tambah Jurusan</a>
                <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
            </div>
            <div class="col">
                <div id="parentbody">
                    <div class="form-check my-2">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="jurusan1" id="jurusan1" placeholder="Jurusan" class="form-control" required>
                            </div>
                            <div class="col">
                                <input type="text" name="deskripsi1" id="deskripsi1" placeholder="Deskripsi" class="form-control" required>
                            </div>
                        </div>
                    </div>
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
            <div class='form-check my-2'>
                <div class="row">
                    <div class="col">
                        <input type='text' name='jurusan${count+1}' id='jurusan${count+1}' placeholder='Jurusan' class='form-control' required>
                    </div>
                    <div class="col">
                        <input type='text' name='deskripsi${count+1}' id='deskripsi${count+1}' placeholder='Deskripsi' class='form-control' required>
                    </div>
                </div>
            </div>`
            +
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection