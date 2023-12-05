@extends('adPanel.layouts.main')

@section('container')
    <div class="table-responsive border border-1 rounded shadow shadow-md p-5">
        <h1 style="color: #0038CF; font-weight: 700;">Tambah Jurusan</h1>
        <h4>Fakultas {{ Str::replace('_', ' ', request()->segment(count(request()->segments())-1)) }}</h4>
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
                </div>
            </div>
            <a href="#" class="btn btn-success mt-2" onclick=addRow() style="font-family: Raleway; font-weight: 500;">Tambah</a>
            <button type="submit" class="btn btn-primary mt-3" style="font-family: Raleway; font-weight: 500;">Submit</button>
        </form>
    </div>

    <script>
        var parBody = document.getElementById('parentbody');

        var count = 0;

        function addRow()
        {
            count++

            var tr = 
            `<div class='form-floating mb-3'><input type='text' name='jurusan${count+1}' id='jurusan${count+1}' class='form-control' required><label for="jurusan${count+1}" class="form-control-label">Jurusan</label></div>`+
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection