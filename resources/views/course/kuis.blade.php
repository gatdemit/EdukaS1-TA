@extends('dashboard.layouts.main')

@section('container-top')
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container m-auto w-100 rounded p-5" style="background-color: #d4dcfc;">
            <h3 class="text-center mb-5" style="font-family: Raleway; font-weight: 800;">Quiz <span class="text-primary"> - {{Str::title(Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())))->getValue()['Judul_Video'])}}</span></h3>
            @php
                $i = 1;
            @endphp
            <form action="/dashboard/quiz/{{ request()->segment(count(request()->segments())) }}" method="post">
                @csrf
                @foreach(Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())) . '/kuis')->getValue() as $questions)
                <h3 style="font-family: Raleway; font-weight: 800;">Pertanyaan {{ $i }}</h3>
        
                <p style="font-family: Raleway;">{{ $questions['pertanyaan'] }}</p>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value ="jawaban 1">
                    <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                      {{ $questions['jawaban']['jawaban 1'] }}
                    </label>
                </div>
        
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 2">
                    <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                      {{ $questions['jawaban']['jawaban 2'] }}
                    </label>
                </div>
        
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 3">
                    <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                      {{ $questions['jawaban']['jawaban 3'] }}
                    </label>
                </div>
        
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 4">
                    <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                      {{ $questions['jawaban']['jawaban 4'] }}
                    </label>
                </div>
        
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 5">
                    <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                      {{ $questions['jawaban']['jawaban 5'] }}
                    </label>
                </div>
                @php
                    $i++;
                @endphp
                @endforeach
                <input type="hidden" name="jurusan" id="jurusan" value="{{ $jurusan }}">
                <input type="hidden" name="question_count" id="question_count" value="{{ $i-1 }}">
                <button class="btn btn-primary m-auto d-block" style="font-family: Raleway; font-weight: 500;">Submit</button>
            </form>
        </div>
@endsection