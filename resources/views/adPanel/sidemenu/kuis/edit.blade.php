@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Quiz</h1>
@endsection

@section('container')
    <div class="table-responsive col-lg-8">
        <form class= "row" action="/adPanel/quiz/{{ request()->segment(count(request()->segments())-1) }}" method="post">
            @method('put')
            @csrf
            <div class="col" id="parentbody">
                @foreach(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/kuis')->getValue() as $kuis)
                <div class="form-floating mb-3">
                    <textarea name="pertanyaan{{ $loop->iteration }}" id="pertanyaan{{ $loop->iteration }}" class="form-control" autofocus>{{ $kuis['pertanyaan'] }}</textarea>
                    <label for="pertanyaan" class="form-control-label">Pertanyaan {{ $loop->iteration }}</label>
                </div>
                <div>
                    @if($kuis['jawaban']['kunci jawaban'] == 'jawaban 1')
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio1" value="jawaban 1" checked>
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+1 }}" id="jawaban1" placeholder="jawaban 1" class="form-control" value="{{ $kuis['jawaban']['jawaban 1'] }}">
                        </div>
                    @else
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio1" value="jawaban 1">
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+1 }}" id="jawaban1" placeholder="jawaban 1" class="form-control" value="{{ $kuis['jawaban']['jawaban 1'] }}">
                        </div>
                    @endif
                    @if($kuis['jawaban']['kunci jawaban'] == 'jawaban 2')
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio2" value="jawaban 2" checked>
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+2 }}" id="jawaban2" placeholder="jawaban 2" class="form-control" value="{{ $kuis['jawaban']['jawaban 2'] }}">
                        </div>
                    @else
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio2" value="jawaban 2">
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+2 }}" id="jawaban2" placeholder="jawaban 2" class="form-control" value="{{ $kuis['jawaban']['jawaban 2'] }}">
                        </div>
                    @endif
                    @if($kuis['jawaban']['kunci jawaban'] == 'jawaban 3')
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio3" value="jawaban 3" checked>
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+3 }}" id="jawaban3" placeholder="jawaban 3" class="form-control" value="{{ $kuis['jawaban']['jawaban 3'] }}">
                        </div>
                    @else
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio3" value="jawaban 3">
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+3 }}" id="jawaban3" placeholder="jawaban 3" class="form-control" value="{{ $kuis['jawaban']['jawaban 3'] }}">
                        </div>
                    @endif
                    @if($kuis['jawaban']['kunci jawaban'] == 'jawaban 4')
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio4" value="jawaban 4" checked>
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+4 }}" id="jawaban4" placeholder="jawaban 4" class="form-control" value="{{ $kuis['jawaban']['jawaban 4'] }}">
                        </div>
                    @else
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio4" value="jawaban 4">
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+4 }}" id="jawaban4" placeholder="jawaban 4" class="form-control" value="{{ $kuis['jawaban']['jawaban 4'] }}">
                        </div>
                    @endif
                    @if($kuis['jawaban']['kunci jawaban'] == 'jawaban 5')
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio5" value="jawaban 5" checked>
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+5 }}" id="jawaban5" placeholder="jawaban 5" class="form-control" value="{{ $kuis['jawaban']['jawaban 5'] }}">
                        </div>
                    @else
                        <div class="form-check my-1">
                            <input class="form-check-input" type="radio" name="radio{{ $loop->iteration }}" id="radio5" value="jawaban 5">
                            <input type="text" name="jawaban{{ (($loop->iteration-1)*5)+5 }}" id="jawaban5" placeholder="jawaban 5" class="form-control" value="{{ $kuis['jawaban']['jawaban 5'] }}">
                        </div>
                    @endif
                </div>
                <input type="hidden" name="count" id="count" value=0>
                @endforeach
            </div>
            <a href="#" class="btn btn-success mt-2" onclick=addRow()>Tambah</a>
            <input type="hidden" name="video" id="video" value="{{ request()->segment(count(request()->segments())-1) }}">
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>

    <script>
        var parBody = document.getElementById('parentbody');

        var count = {{ count(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/kuis')->getValue()) }}-1;

        console.log(count);

        function addRow()
        {
            count++

            console.log(count);

            var tr = 
            `<div class='form-floating mb-3'><textarea name='pertanyaan${count+1}' id='pertanyaan${count+1}'  class='form-control' autofocus></textarea><label for='pertanyaan' class='form-control-label'>Pertanyaan ${count+1}</label></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 1"><input type='text' name='jawaban${(count*5)+1}' id='jawaban${(count*5)+1}' placeholder='jawaban 1' class='form-control'></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 2"><input type='text' name='jawaban${(count*5)+2}' id='jawaban${(count*5)+2}' placeholder='jawaban 2' class='form-control'></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 3"><input type='text' name='jawaban${(count*5)+3}' id='jawaban${(count*5)+3}' placeholder='jawaban 3' class='form-control'></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 4"><input type='text' name='jawaban${(count*5)+4}' id='jawaban${(count*5)+4}' placeholder='jawaban 4' class='form-control'></div>`+
            `<div class='form-check my-1'><input class='form-check-input' type='radio' name='radio${count+1}' id='radio${count+1}' value="jawaban 5"><input type='text' name='jawaban${(count*5)+5}' id='jawaban${(count*5)+5}' placeholder='jawaban 5' class='form-control'></div>`+
            `<input type="hidden" name="count" id="count" value=${count}>`;
            $(parBody).append(tr);
        }
    </script>
@endsection