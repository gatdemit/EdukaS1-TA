@extends('adPanel.layouts.main')

@section('container')
    <div class="table-responsive border border-1 rounded shadow shadow-md p-5">
        <h1 style="color: #0038CF; font-weight: 700;">Fakultas dan Jurusan</h1>
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
            <a href="/adPanel/fakultas/create">
                <button class="btn btn-primary" style="font-weight: 600;">Tambah Fakultas</button>
            </a>
            <form class="row" action="/adPanel/fakultas" method="post">
                @csrf
                <div class="input-group mb-3 w-50 ms-auto">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input name="search" id="search" type="text" class="form-control" placeholder="Cari Fakultas disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                    <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
                </div>
                <a class="mb-3" href="/adPanel/video" style="text-align: right;">Clear Search</a>
            </form>
        </div>
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr style="text-align: center;">
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Action</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @if($fakultas!=null)
                    @if($search)
                        @foreach($fakultas as $snapshot)
                             @if(Str::contains($snapshot['Value'], $query)) 
                                <tr style="text-align: center">
                                    <td style="font-weight: 500;">{{ $snapshot['Value'] }}</td>
                                    <td>
                                        <a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" class="btn btn-success rounded-pill">Lihat Jurusan</a>
                                    </td>
                                    <td><a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}/edit" class="btn btn-primary rounded-pill">Tambah Jurusan</a></td>
                                    <td>
                                        <form action="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Value'] }}">
                                            <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                    @foreach ($fakultas as $snapshot)
                        <tr style="text-align: center;">
                            <td>{{ $snapshot['Value'] }}</td>
                            <td>
                                <a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" class="btn btn-success rounded-pill">Lihat Jurusan</a>
                            </td>
                            <td><a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}/edit" class="btn btn-primary rounded-pill">Tambah Jurusan</a></td>
                            <td>
                                <form action="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Value'] }}">
                                    <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                @else
                <tr>
                    <td>Fakultas don't exist</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection