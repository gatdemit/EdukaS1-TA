@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-4">
    <div class="card-body">
        <h1 style="color: #0038CF; font-weight: 700;">Kuis</h1>
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
                    <th scope="col" style="text-align: center;">Nilai Kuis</th>
                    <th scope="col" style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getValue())
                    @foreach(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getValue() as $videos)
                        @foreach($videos as $vids)
                            <tr>
                                <td onclick="toggleTitle(this)" style="font-weight: 500; max-width:200px; cursor: pointer;" class="text-truncate">{{ Str::title(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Judul_Video']) }}</td>
                                <td style="font-weight: 500;">{{ Str::title($vids['Fakultas']) }}</td>
                                <td style="font-weight: 500;">{{ Str::title($vids['Jurusan']) }}</td>
                                @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'] . '/kuis')->getSnapshot()->exists())
                                    @if(array_key_exists('nilai', $vids))
                                        <td style="font-weight: 500; text-align: center;">{{ $vids['nilai'] }}</td>
                                        <td style="font-weight: 500; text-align: center;">
                                            <form action="/dashboard/quiz/{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Video'] }}/1" method="post">
                                                @csrf
                                                <input type="hidden" name="jur" id="jur" value="{{ Str::replace(' ', '_', $vids['Jurusan']) }}">
                                                <button class="btn btn-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    @else
                                        <td style="font-weight: 500; text-align: center;">-</td>
                                        <td style="font-weight: 500; text-align: center;">
                                            <form action="/dashboard/quiz/{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Video'] }}/1" method="post">
                                                @csrf
                                                <input type="hidden" name="jur" id="jur" value="{{ Str::replace(' ', '_', $vids['Jurusan']) }}">
                                                <button class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-vector-pen" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M10.646.646a.5.5 0 0 1 .708 0l4 4a.5.5 0 0 1 0 .708l-1.902 1.902-.829 3.313a1.5 1.5 0 0 1-1.024 1.073L1.254 14.746 4.358 4.4A1.5 1.5 0 0 1 5.43 3.377l3.313-.828zm-1.8 2.908-3.173.793a.5.5 0 0 0-.358.342l-2.57 8.565 8.567-2.57a.5.5 0 0 0 .34-.357l.794-3.174-3.6-3.6z"/>
                                                        <path fill-rule="evenodd" d="M2.832 13.228 8 9a1 1 0 1 0-1-1l-4.228 5.168-.026.086z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                @else
                                    <td style="font-weight: 500;">Kuis Belum Dibuat</td>
                                    <td style="font-weight: 500;"></td>
                                @endif
                            </tr>
                        @endforeach
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
    <script>
        function toggleTitle(el) {
            el.className = el.className.includes('text-truncate') ? '' : 'text-truncate'
        }
    </script>
</div>
@endsection
