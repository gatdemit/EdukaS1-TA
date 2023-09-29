@extends('dashboard.layouts.main')

@section('container-header')
    <h1>Welcome, {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['username'] }}</h1>
@endsection

@section('container-top')
    @include('dashboard.layouts.header')
    @include('dashboard.layouts.sidebar')
@endsection

@section('container-main')
    @if(Firebase::database()->getReference('users/'. Session::get('email') . '/vids')->getValue() != null)
        <div class="card my-3 pb-3">
            @foreach(Firebase::database()->getReference('users/'. Session::get('email') . '/vids')->getValue() as $data)
                <a href="/course/{{ $data['Jurusan'] }}/{{ $data['Video'] }}">
                    <h1>{{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Judul_Video'] }}</h1>
                    <p>Fakultas: {{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Fakultas'] }}</p>
                    <p>Jurusan: {{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Jurusan'] }}</p>
                    <p>{{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Deskripsi'] }}</p>
                </a>
            @endforeach
        </div>
    @else
        <h1>You don't have any videos yet</h1>
    @endif
@endsection
