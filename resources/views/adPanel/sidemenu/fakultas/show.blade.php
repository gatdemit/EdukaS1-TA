@extends('adPanel.layouts.main')

@section('container')
        <h4 style="color: #0038CF; font-weight: 500;">Fakultas {{ Str::replace('_', ' ', request()->segment(count(request()->segments()))) }}</h4>
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
        <form class="row" action="/adPanel/fakultas/{{ request()->segment(count(request()->segments())) }}" method="post">
            @method('put')
            @csrf
            <div class="input-group mb-3 w-50 ms-auto">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input name="search" id="search" type="text" class="form-control" placeholder="Cari Jurusan disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
            </div>
            <a class="mb-3" href="/adPanel/fakultas/{{ request()->segment(count(request()->segments())) }}" style="text-align: right;">Clear Search</a>
        </form>
        <table class="table table-striped table-sm table-hover">
            <thead>
                <tr>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col" style="text-align: center;">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $key = 0;
                @endphp
                @if(Firebase::database()->getReference('faculties/' . request()->segment(count(request()->segments())) . '/jurusan')->getSnapshot()->exists())
                    @if($search)
                        @foreach(Firebase::database()->getReference('faculties/' . request()->segment(count(request()->segments())) . '/jurusan')->getValue() as $snapshot)
                             @if(Str::contains($snapshot['Value'], $query)) 
                             <tr>
                                <td>{{ Str::replace('_', ' ', request()->segment(count(request()->segments()))) }}</td>
                                <td>{{ $snapshot['Value'] }}</td>
                                <td style="text-align: center;">
                                    <form action="/adPanel/fakultas" method="POST">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Value']) }}">
                                        <input type="hidden" name="fakultas" id="fakultas" value="{{ request()->segment(count(request()->segments())) }}">
                                        <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                                @php
                                    $key++;
                                @endphp
                            @endif
                        @endforeach
                    @else
                    @foreach (Firebase::database()->getReference('faculties/' . request()->segment(count(request()->segments())) . '/jurusan')->getValue() as $snapshot)
                        <tr>
                            <td>{{ Str::replace('_', ' ', request()->segment(count(request()->segments()))) }}</td>
                            <td>{{ $snapshot['Value'] }}</td>
                            <td style="text-align: center;">
                                <form action="/adPanel/fakultas" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Value']) }}">
                                    <input type="hidden" name="fakultas" id="fakultas" value="{{ request()->segment(count(request()->segments())) }}">
                                    <button class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @php
                            $key++;
                        @endphp
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