@extends('layouts.main')

<div class="container">
    <div class="row">    
        @if(Str::contains(Str::replace('_',' ', request()->segment(count(request()->segments()))), $jurusan))
            @foreach($videos as $snapshot)
                @if($snapshot['Jurusan']==Str::replace('_',' ', request()->segment(count(request()->segments()))))
                    <div class="card my-3 pb-3">
                        @if(Session::get('user'))
                        <form action="/keranjang" method="post">
                            @csrf        
                            <div class="col">
                                <a href="/course/{{ $snapshot['Jurusan'] }}/{{ $snapshot['Video'] }}">
                                    <input type="hidden" name="judul" id="judul" value="{{ $snapshot['Judul_Video'] }}">
                                    <input type="hidden" name="harga" id="harga" value="{{ $snapshot['Harga'] }}">
                                    <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                    <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Fakultas'] }}">
                                    <input type="hidden" name="jurusan" id="jurusan" value="{{ $snapshot['Jurusan'] }}">
                                    <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                    <h1>ini {{ $snapshot['Judul_Video'] }}</h1>
                                    <p>ini {{ $snapshot['Fakultas'] }}</p>
                                    <p>ini {{ $snapshot['Jurusan'] }}</p>
                                    <p>ini {{ $snapshot['Harga'] }}</p>
                                    <p>ini {{ $snapshot['Deskripsi'] }}</p>
                                </a>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary">Beli</button>
                            </div>
                        </form>
                        @else
                        <div class="col">
                            <a href="/course/{{ $snapshot['Jurusan'] }}/{{ $snapshot['Video'] }}">
                                <h1>ini {{ $snapshot['Judul_Video'] }}</h1>
                                <p>ini {{ $snapshot['Fakultas'] }}</p>
                                <p>ini {{ $snapshot['Jurusan'] }}</p>
                                <p>ini {{ $snapshot['Harga'] }}</p>
                                <p>ini {{ $snapshot['Deskripsi'] }}</p>
                            </a>
                        </div>
                        <div class="col">
                            <a class="btn btn-primary" href="/login">Login untuk beli</a>
                        </div>
                        @endif
                    </div>
                @endif
            @endforeach
        @else
            <h1>Course doesn't exist</h1>
        @endif
    </div>
</div>






