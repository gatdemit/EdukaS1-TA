@extends('layouts.main')

<div class="container">
    <div class="row">
        <video width="320" height="240" controls>
            <source src="{{ asset('storage/'. Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Link']) }}" type="video/mp4">
        </video>
        <h1>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Judul_Video'] }}</h1>
        <p>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Deskripsi'] }}</p>
        @if(Session::get('user'))
            <a href="/quiz/{{ request()->segment(count(request()->segments())) }}" class="btn btn-success">Kerjakan Quiz</a>
        @endif
    </div>
</div>