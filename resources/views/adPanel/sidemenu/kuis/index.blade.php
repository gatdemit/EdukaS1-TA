@extends('adPanel.layouts.main')

@section('container')
@yield('container-header')
    <div class="table-responsive border border-1 rounded shadow shadow-md p-5">
        <h1 style="color: #0038CF; font-weight: 700;">Quiz</h1>
        @if(session()->has('success'))
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form class="row" action="/adPanel/quiz" method="post">
            @csrf
            <div class="input-group mb-3 w-50 ms-auto">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input name="search" id="search" type="text" class="form-control" placeholder="Cari Quiz disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
            </div>
            <a class="mb-5" href="/adPanel/quiz" style="text-align: right;">Clear Search</a>
        </form>
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr style="text-align: center;">
                    <th scope="col">Judul Video</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($search)
                    @foreach($videos as $jurusan)
                        @foreach($jurusan as $video)
                            @if(Str::contains($video['Judul_Video'], $query) || Str::contains($video['Deskripsi'], $query) || Str::contains($video['Jurusan'], $query) || Str::contains($video['Fakultas'], $query))
                                <tr>
                                    <td style="font-weight: 500;">{{ Str::title($video['Judul_Video']) }}</td>
                                    <td style="font-weight: 500; text-align: center;">{{ $video['Fakultas'] }}</td>
                                    <td style="font-weight: 500; text-align: center;">{{ $video['Jurusan'] }}</td>
                                    <td style="text-align: center;">
                                        @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'] . '/kuis')->getValue()==null)
                                            <form action="quiz/create" method="POST">
                                                @csrf
                                                <input type="hidden" name="video" id="video" value='{{ $video['Video'] }}'>
                                                <input type="hidden" name="jurusan" id="jurusan" value='{{ Str::replace(' ', '_', $video['Jurusan']) }}'>
                                                <button class="btn btn-primary rounded-pill">Tambah Kuis</button>
                                            </form>
                                        @else
                                            <form action="/adPanel/quiz/{{ $video['Video'] }}/edit">
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                                <button class="btn btn-warning rounded-pill">Edit Kuis</button>
                                            </form>
                                            <form action="/adPanel/quiz/{{ $video['Video'] }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="video" id="video" value="{{ $video['Video'] }}">
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                                <button class="btn btn-danger rounded-pill mt-2" onclick="return confirm('Are you sure?')">Hapus Kuis</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    @foreach($videos as $jurusan)
                        @foreach($jurusan as $video)
                            <tr>
                                <td style="font-weight: 500;">{{ Str::title($video['Judul_Video']) }}</td>
                                <td style="font-weight: 500; text-align: center;">{{ $video['Fakultas'] }}</td>
                                <td style="font-weight: 500; text-align: center;">{{ $video['Jurusan'] }}</td>
                                <td style="text-align: center;">
                                    @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'] . '/kuis')->getValue()==null)
                                        <form action="quiz/create" method="POST">
                                            @csrf
                                            <input type="hidden" name="video" id="video" value='{{ $video['Video'] }}'>
                                            <input type="hidden" name="jurusan" id="jurusan" value='{{ Str::replace(' ', '_', $video['Jurusan']) }}'>
                                            <button class="btn btn-primary rounded-pill">Tambah Kuis</button>
                                        </form>
                                    @else
                                        <form action="/adPanel/quiz/{{ $video['Video'] }}/edit">
                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                            <button class="btn btn-warning rounded-pill">Edit Kuis</button>
                                        </form>
                                        <form action="/adPanel/quiz/{{ $video['Video'] }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="video" id="video" value="{{ $video['Video'] }}">
                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                            <button class="btn btn-danger rounded-pill mt-2" onclick="return confirm('Are you sure?')">Hapus Kuis</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection