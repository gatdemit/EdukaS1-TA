@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Quizzes</h1>
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
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Judul Video</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videos as $video)
                    @if(Firebase::database()->getReference('videos/' . $video['Video'] . '/kuis')->getValue()==null)
                        <tr>
                            <td>{{ $video['Judul_Video'] }}</td>
                            <td>{{ $video['Fakultas'] }}</td>
                            <td>{{ $video['Jurusan'] }}</td>
                            <td>
                                <form action="quiz/create" method="POST">
                                    @csrf
                                    <input type="hidden" name="video" id="video" value='{{ $video['Video'] }}'>
                                    <button class="btn btn-primary">Tambah Kuis</button>
                                </form>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $video['Judul_Video'] }}</td>
                            <td>{{ $video['Fakultas'] }}</td>
                            <td>{{ $video['Jurusan'] }}</td>
                            <td>
                                <a href="/adPanel/quiz/{{ $video['Video'] }}/edit" class="btn btn-warning">Edit Kuis</a>
                                <form action="/adPanel/quiz/{{ $video['Video'] }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="video" id="video" value="{{ $video['Video'] }}">
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus Kuis</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection