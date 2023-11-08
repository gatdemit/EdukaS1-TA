@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Upload Video</h1>
@endsection

@section('container')
    <div class="table-responsive col-lg-8">
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
        <a href="/adPanel/video/create">
            <button class="btn btn-primary">Upload Video</button>
        </a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Judul Video</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @if($videos!=null)
                    @foreach ($videos as $snapshot)
                        <tr>
                            <td>{{ $snapshot['Judul_Video'] }}</td>
                            <td>{{ $snapshot['Fakultas'] }}</td>
                            <td>{{ $snapshot['Jurusan'] }}</td>
                            <td>{{ $snapshot['Harga'] }}</td>
                            <td><a href="/adPanel/video/{{ $snapshot['Video'] }}/edit" class="btn btn-warning">Edit</a></td>
                            <td>
                                <form action="/adPanel/video/{{ $snapshot['Video'] }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td>video don't exist</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection