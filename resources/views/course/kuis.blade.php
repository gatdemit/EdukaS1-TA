@extends('layouts.main')

<div class="container">
    <div class="row">
        <form action="/quiz/{{ request()->segment(count(request()->segments())) }}" method="POST">
            @csrf
            @foreach(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/kuis')->getValue() as $questions)
            <p>{{ $questions['pertanyaan'] }}</p>
            <div class="form-check my-1">
                <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 1">
                <p>{{ $questions['jawaban']['jawaban 1'] }}</p>
            </div>
            <div class="form-check my-1">
                <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 2">
                <p>{{ $questions['jawaban']['jawaban 2'] }}</p>
            </div>
            <div class="form-check my-1">
                <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 3">
                <p>{{ $questions['jawaban']['jawaban 3'] }}</p>
            </div>
            <div class="form-check my-1">
                <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 4">
                <p>{{ $questions['jawaban']['jawaban 4'] }}</p>
            </div>
            <div class="form-check my-1">
                <input class="form-check-input" type="radio" name="{{ $questions['pertanyaan'] }}" id="radio1" value="jawaban 5">
                <p>{{ $questions['jawaban']['jawaban 5'] }}</p>
            </div>
            <input type="hidden" name="question_count" id="question_count" value="{{ count(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/kuis')->getValue()) }}">
            <input type="hidden" name="video" id="video" value="{{ request()->segment(count(request()->segments())) }}">
            @endforeach
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>