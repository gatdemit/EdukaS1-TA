@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-4">
    <div class="card-body">
        <h1 style="color: #0038CF; font-weight: 700;">My Quiz</h1>
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
                @if(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getValue())
                    @foreach(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getValue() as $vids)
                        <tr>
                            <td style="font-weight: 500;">{{ Str::title(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Judul_Video']) }}</td>
                            <td style="font-weight: 500;">{{ Str::title($vids['Fakultas']) }}</td>
                            <td style="font-weight: 500;">{{ Str::title($vids['Jurusan']) }}</td>
                            @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'] . '/kuis')->getSnapshot()->exists())
                                @if(array_key_exists('nilai', $vids))
                                    <td style="font-weight: 500;">{{ $vids['nilai'] }}</td>
                                    <td style="font-weight: 500;">
                                        <form action="/dashboard/quiz/{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Video'] }}/1" method="post">
                                            @csrf
                                            <input type="hidden" name="jur" id="jur" value="{{ Str::replace(' ', '_', $vids['Jurusan']) }}">
                                            <button class="btn btn-warning rounded-pill">Kerjakan Ulang</button>
                                        </form>
                                    </td>
                                @else
                                    <td style="font-weight: 500;">Kuis Belum Dikerjakan</td>
                                    <td style="font-weight: 500;">
                                        <form action="/dashboard/quiz/{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Video'] }}/1" method="post">
                                            @csrf
                                            <input type="hidden" name="jur" id="jur" value="{{ Str::replace(' ', '_', $vids['Jurusan']) }}">
                                            <button class="btn btn-primary rounded-pill">Kerjakan</button>
                                        </form>
                                    </td>
                                @endif
                            @else
                                <td style="font-weight: 500;">Kuis Belum Dibuat</td>
                            @endif
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td>
                        Kuis Doesn't Exist Yet
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
