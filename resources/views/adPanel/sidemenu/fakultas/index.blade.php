@extends('adPanel.layouts.main')

@section('container')
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
            <a class="mb-3" href="/adPanel/fakultas" style="text-align: right;">Clear Search</a>
        </form>
    </div>
    <table class="table table-striped table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">Fakultas</th>
                <th scope="col" style="text-align: center;">Jurusan</th>
                <th scope="col" style="text-align: center;">Tambah Jurusan</th>
                <th scope="col" style="text-align: center;">Hapus</th>
            </tr>
        </thead>
        <tbody>
            @if($fakultas!=null)
                @if($search)
                    @foreach($fakultas as $snapshot)
                        @if(count($snapshot) <= 3)
                            @if(Str::contains(Str::upper($snapshot['Value']), Str::upper($query)))
                                <tr>
                                    <td>{{ $snapshot['Value'] }}</td>
                                    <td style="text-align: center;">
                                        <a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" class="btn btn-success rounded-pill" style="text-decoration: none; color: white;">Lihat Jurusan</a>
                                    </td style="text-align: center;">
                                    <td style="text-align: center;"><a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}/edit" class="btn btn-primary rounded-pill" style="text-decoration: none; color: white;">Tambah Jurusan</a></td>
                                    <td style="text-align: center;">
                                        <form action="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Value'] }}">
                                            <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @else
                    @foreach ($fakultas as $snapshot)
                        @if(count($snapshot) < 3)
                            <tr>
                                <td>{{ $snapshot['Value'] }}</td>
                                <td style="text-align: center;">
                                    <a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" class="btn btn-success rounded-pill" style="text-decoration: none; color: white;">Lihat Jurusan</a>
                                </td style="text-align: center;">
                                <td style="text-align: center;"><a href="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}/edit" class="btn btn-primary rounded-pill" style="text-decoration: none; color: white;">Tambah Jurusan</a></td>
                                <td style="text-align: center;">
                                    <form action="/adPanel/fakultas/{{ Str::replace(' ', '_', $snapshot['Value']) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Value'] }}">
                                        <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @else
            <tr>
                <td>Fakultas don't exist</td>
            </tr>
            @endif
        </tbody>
    </table>
@endsection