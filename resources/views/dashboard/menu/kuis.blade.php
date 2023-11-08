@extends('dashboard.layouts.main')

@section('container-header')
    <h1>My Quiz</h1>
@endsection

@section('container-main')
<div class="table-responsive col-lg-8">
    @if(session()->has('success'))
        <div class="alert alert-success  alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Judul Video</th>
                <th scope="col">Fakultas</th>
                <th scope="col">Jurusan</th>
                <th scope="col">Nilai Kuis</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getValue() as $vids)
                <tr>
                    <td>{{ Firebase::database()->getReference('videos/' . $vids['Video'])->getValue()['Judul_Video'] }}</td>
                    <td>{{ $vids['Fakultas'] }}</td>
                    <td>{{ $vids['Jurusan'] }}</td>
                    @if(array_key_exists('nilai', $vids))
                        <td>{{ $vids['nilai'] }}</td>
                        <td><a href="/dashboard/quiz/{{ Firebase::database()->getReference('videos/' . $vids['Video'])->getValue()['Video'] }}" class="btn btn-warning">Kerjakan Ulang</a></td>
                    @else
                        <td>Kuis Belum Dikerjakan</td>
                        <td><a href="/dashboard/quiz/{{ Firebase::database()->getReference('videos/' . $vids['Video'])->getValue()['Video'] }}" class="btn btn-primary">Kerjakan</a></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
