@extends('adPanel.layouts.main')

@section('container')
    <div class="table-responsive border border-1 rounded shadow shadow-md p-5">
        <h1 style="color: #0038CF;; font-weight: 700;">Video</h1>
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
        <div class="d-flex justify-content-between">
            <a href="/adPanel/video/create">
                <button class="btn btn-primary" style="font-weight: 600;">Upload Video</button>
            </a>
            <form class="row" action="/adPanel/video" method="post">
                @csrf
                <div class="input-group mb-3 w-50 ms-auto">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input name="search" id="search" type="text" class="form-control" placeholder="Cari Video disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                    <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
                </div>
                <a class="mb-3" href="/adPanel/video" style="text-align: right;">Clear Search</a>
            </form>
        </div>
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr style="text-align: center;">
                    <th scope="col">Judul Video</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @if($jurusan!=null)
                    @if($search)
                        @foreach($jurusan as $videos)
                            @foreach ($videos as $snapshot)
                                @if(Str::contains($snapshot['Judul_Video'], $query) || Str::contains($snapshot['Deskripsi'], $query) || Str::contains($snapshot['Jurusan'], $query) || Str::contains($snapshot['Fakultas'], $query) || Str::contains($snapshot['Harga'], $query))
                                    <tr>
                                        <td>{{ Str::title($snapshot['Judul_Video']) }}</td>
                                        <td style="text-align: center; font-weight: 500;">{{ $snapshot['Fakultas'] }}</td>
                                        <td style="text-align: center; font-weight: 500;">{{ $snapshot['Jurusan'] }}</td>
                                        <td style="text-align: center; font-weight: 500;">Rp {{ $snapshot['Harga'] }}</td>
                                        <td>
                                            <form action="/adPanel/video/{{ $snapshot['Video'] }}/edit" method="post">
                                                @csrf
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                                <button class="btn btn-warning rounded-pill" style="text-align: center;">Edit</button>
                                            </form>
                                        </td>
                                        <td>
                                            @if($snapshot['Active'])
                                                <form action="/adPanel/video/{{ $snapshot['Video'] }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                                    <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                                    <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')" style="text-align: center;">Deactivate</button>
                                                </form>
                                            @else
                                                <form action="/adPanel/video/{{ $snapshot['Video'] }}/react" method="POST">
                                                    @method('put')
                                                    @csrf
                                                    <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                                    <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                                    <button class="btn btn-primary rounded-pill" onclick="return confirm('Are you sure?')" style="text-align: center;">Reactivate</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        @foreach($jurusan as $videos)
                            @foreach ($videos as $snapshot)
                                <tr>
                                    <td>{{ Str::title($snapshot['Judul_Video']) }}</td>
                                    <td style="text-align: center; font-weight: 500;">{{ $snapshot['Fakultas'] }}</td>
                                    <td style="text-align: center; font-weight: 500;">{{ $snapshot['Jurusan'] }}</td>
                                    <td style="text-align: center; font-weight: 500;">Rp {{ $snapshot['Harga'] }}</td>
                                    <td>
                                        <form action="/adPanel/video/{{ $snapshot['Video'] }}/edit" method="post">
                                            @csrf
                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                            <button class="btn btn-warning rounded-pill" style="text-align: center;">Edit</button>
                                        </form>
                                    </td>
                                    <td>
                                        @if($snapshot['Active'])
                                            <form action="/adPanel/video/{{ $snapshot['Video'] }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                                <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')" style="text-align: center;">Deactivate</button>
                                            </form>
                                        @else
                                            <form action="/adPanel/video/{{ $snapshot['Video'] }}/react" method="POST">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                                <button class="btn btn-primary rounded-pill" onclick="return confirm('Are you sure?')" style="text-align: center;">Reactivate</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                @else
                <tr>
                    <td>video don't exist</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection