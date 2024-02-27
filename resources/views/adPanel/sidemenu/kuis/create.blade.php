@extends('adPanel.layouts.main')

@section('container')
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class= "row" action="/adPanel/quiz" method="post">
            @csrf
            <div class="col" id="parentbody">
                <label class="mb-2" for="pertanyaan1">Pertanyaan 1</label>
                <div class="form-group mb-3">
                    <textarea name="pertanyaan1" id="pertanyaan1" class="form-control" required></textarea>
                </div>
                <div>
                    <div class="form-check my-1">
                        <input style="border: solid 1px;" class="form-check-input" type="radio" name="radio1" id="radio1" value="jawaban 1" required>
                        <input type="text" name="jawaban1" id="jawaban1" placeholder="jawaban 1" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input style="border: solid 1px;" class="form-check-input" type="radio" name="radio1" id="radio2" value="jawaban 2" required>
                        <input type="text" name="jawaban2" id="jawaban2" placeholder="jawaban 2" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input style="border: solid 1px;" class="form-check-input" type="radio" name="radio1" id="radio3" value="jawaban 3" required>
                        <input type="text" name="jawaban3" id="jawaban3" placeholder="jawaban 3" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input style="border: solid 1px;" class="form-check-input" type="radio" name="radio1" id="radio4" value="jawaban 4" required>
                        <input type="text" name="jawaban4" id="jawaban4" placeholder="jawaban 4" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input style="border: solid 1px;" class="form-check-input" type="radio" name="radio1" id="radio5" value="jawaban 5" required>
                        <input type="text" name="jawaban5" id="jawaban5" placeholder="jawaban 5" class="form-control" required>
                    </div>
                </div>
                <input type="hidden" name="count" id="count" value=0>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <a href="#" class="btn btn-outline-success" onclick=addRow() style="font-weight: 500;">Tambah</a>
                    <button type="submit" class="btn btn-primary" style="font-weight: 500;">Submit</button>
                </div>
            </div>
            <input type="hidden" name="video" id="video" value="{{ $video }}">
            <input type="hidden" name="jurusan" id="jurusan" value="{{ $jurusan }}">
        </form>

    <script>
        var parBody = document.getElementById('parentbody');

        var count = 0;

        function addRow()
        {
            count++

            var tr = 
            `<label class="my-2" for="pertanyaan${count+1}">Pertanyaan ${count+1}</label><div class='form-group mb-3'><textarea name='pertanyaan${count+1}' id='pertanyaan${count+1}'  class='form-control' required></textarea></div>`+
            `<div class='form-check my-1'><input style="border: solid 1px;" class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 1" required><input type='text' name='jawaban${(count*5)+1}' id='jawaban${(count*5)+1}' placeholder='jawaban 1' class='form-control' required></div>`+
            `<div class='form-check my-1'><input style="border: solid 1px;" class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 2" required><input type='text' name='jawaban${(count*5)+2}' id='jawaban${(count*5)+2}' placeholder='jawaban 2' class='form-control' required></div>`+
            `<div class='form-check my-1'><input style="border: solid 1px;" class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 3" required><input type='text' name='jawaban${(count*5)+3}' id='jawaban${(count*5)+3}' placeholder='jawaban 3' class='form-control' required></div>`+
            `<div class='form-check my-1'><input style="border: solid 1px;" class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 4" required><input type='text' name='jawaban${(count*5)+4}' id='jawaban${(count*5)+4}' placeholder='jawaban 4' class='form-control' required></div>`+
            `<div class='form-check my-1'><input style="border: solid 1px;" class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 5" required><input type='text' name='jawaban${(count*5)+5}' id='jawaban${(count*5)+5}' placeholder='jawaban 5' class='form-control' required></div>`+
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection