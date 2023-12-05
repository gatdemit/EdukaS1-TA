@extends('adPanel.layouts.main')

@section('container')
    <div class="table-responsive border border-1 rounded shadow shadow-md p-5">
        <h1 style="color: #0038CF; font-weight: 700;">Tambah Quiz</h1>
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class= "row" action="/adPanel/quiz" method="post">
            @csrf
            <div class="col" id="parentbody">
                <div class="form-floating mb-3">
                    <textarea name="pertanyaan1" id="pertanyaan1" class="form-control" autofocus required></textarea>
                    <label for="pertanyaan" class="form-control-label">Pertanyaan 1</label>
                </div>
                <div>
                    <div class="form-check my-1">
                        <input class="form-check-input" type="radio" name="radio1" id="radio1" value="jawaban 1" required>
                        <input type="text" name="jawaban1" id="jawaban1" placeholder="jawaban 1" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input class="form-check-input" type="radio" name="radio1" id="radio2" value="jawaban 2" required>
                        <input type="text" name="jawaban2" id="jawaban2" placeholder="jawaban 2" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input class="form-check-input" type="radio" name="radio1" id="radio3" value="jawaban 3" required>
                        <input type="text" name="jawaban3" id="jawaban3" placeholder="jawaban 3" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input class="form-check-input" type="radio" name="radio1" id="radio4" value="jawaban 4" required>
                        <input type="text" name="jawaban4" id="jawaban4" placeholder="jawaban 4" class="form-control" required>
                    </div>
                    <div class="form-check my-1">
                        <input class="form-check-input" type="radio" name="radio1" id="radio5" value="jawaban 5" required>
                        <input type="text" name="jawaban5" id="jawaban5" placeholder="jawaban 5" class="form-control" required>
                    </div>
                </div>
                <input type="hidden" name="count" id="count" value=0>
            </div>
            <a href="#" class="btn btn-success mt-2" onclick=addRow() style="font-family: Raleway; font-weight: 500;">Tambah</a>
            <input type="hidden" name="video" id="video" value="{{ $video }}">
            <input type="hidden" name="jurusan" id="jurusan" value="{{ $jurusan }}">
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
            `<div class='form-floating mb-3'><textarea name='pertanyaan${count+1}' id='pertanyaan${count+1}'  class='form-control' required></textarea><label for='pertanyaan' class='form-control-label'>Pertanyaan ${count+1}</label></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 1" required><input type='text' name='jawaban${(count*5)+1}' id='jawaban${(count*5)+1}' placeholder='jawaban 1' class='form-control' required></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 2" required><input type='text' name='jawaban${(count*5)+2}' id='jawaban${(count*5)+2}' placeholder='jawaban 2' class='form-control' required></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 3" required><input type='text' name='jawaban${(count*5)+3}' id='jawaban${(count*5)+3}' placeholder='jawaban 3' class='form-control' required></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 4" required><input type='text' name='jawaban${(count*5)+4}' id='jawaban${(count*5)+4}' placeholder='jawaban 4' class='form-control' required></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 5" required><input type='text' name='jawaban${(count*5)+5}' id='jawaban${(count*5)+5}' placeholder='jawaban 5' class='form-control' required></div>`+
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection