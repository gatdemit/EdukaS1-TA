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
                            @if(Str::contains(Str::upper($video['Judul_Video']), Str::upper($query)) || Str::contains(Str::upper($video['Deskripsi']), Str::upper($query)) || Str::contains(Str::upper($video['Jurusan']), Str::upper($query)) || Str::contains(Str::upper($video['Fakultas']), Str::upper($query)))
                                <tr>
                                    <td onclick="toggleTitle(this)" style="font-weight: 500; max-width: 500px; cursor: pointer" class="text-truncate">{{ Str::title($video['Judul_Video']) }}</td>
                                    <td style="font-weight: 500; text-align: center;">{{ $video['Fakultas'] }}</td>
                                    <td style="font-weight: 500; text-align: center;">{{ $video['Jurusan'] }}</td>
                                    <td style="text-align: center;">
                                        @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'] . '/kuis')->getValue()==null)
                                            <form action="quiz/create" method="POST">
                                                @csrf
                                                <input type="hidden" name="video" id="video" value='{{ $video['Video'] }}'>
                                                <input type="hidden" name="jurusan" id="jurusan" value='{{ Str::replace(' ', '_', $video['Jurusan']) }}'>
                                                <button class="btn btn-primary d-flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="/adPanel/quiz/{{ $video['Video'] }}/edit">
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                                <button class="btn btn-warning d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-vector-pen" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M10.646.646a.5.5 0 0 1 .708 0l4 4a.5.5 0 0 1 0 .708l-1.902 1.902-.829 3.313a1.5 1.5 0 0 1-1.024 1.073L1.254 14.746 4.358 4.4A1.5 1.5 0 0 1 5.43 3.377l3.313-.828zm-1.8 2.908-3.173.793a.5.5 0 0 0-.358.342l-2.57 8.565 8.567-2.57a.5.5 0 0 0 .34-.357l.794-3.174-3.6-3.6z"/>
                                                    <path fill-rule="evenodd" d="M2.832 13.228 8 9a1 1 0 1 0-1-1l-4.228 5.168-.026.086z"/>
                                                  </svg></button>
                                            </form>
                                            <form action="/adPanel/quiz/{{ $video['Video'] }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="video" id="video" value="{{ $video['Video'] }}">
                                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                                <button class="btn btn-danger d-flex mt-2" onclick="return confirm('Are you sure?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                  </svg></button>
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
                                <td onclick="toggleTitle(this)" style="font-weight: 500; max-width: 500px; cursor: pointer" class="text-truncate">{{ Str::title($video['Judul_Video']) }}</td>
                                <td style="font-weight: 500; text-align: center;">{{ $video['Fakultas'] }}</td>
                                <td style="font-weight: 500; text-align: center;">{{ $video['Jurusan'] }}</td>
                                <td style="text-align: center;">
                                    @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'] . '/kuis')->getValue()==null)
                                        <form action="quiz/create" method="POST">
                                            @csrf
                                            <input type="hidden" name="video" id="video" value='{{ $video['Video'] }}'>
                                            <input type="hidden" name="jurusan" id="jurusan" value='{{ Str::replace(' ', '_', $video['Jurusan']) }}'>
                                            <button class="btn btn-primary d-flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="/adPanel/quiz/{{ $video['Video'] }}/edit">
                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                            <button class="btn btn-warning d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-vector-pen" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M10.646.646a.5.5 0 0 1 .708 0l4 4a.5.5 0 0 1 0 .708l-1.902 1.902-.829 3.313a1.5 1.5 0 0 1-1.024 1.073L1.254 14.746 4.358 4.4A1.5 1.5 0 0 1 5.43 3.377l3.313-.828zm-1.8 2.908-3.173.793a.5.5 0 0 0-.358.342l-2.57 8.565 8.567-2.57a.5.5 0 0 0 .34-.357l.794-3.174-3.6-3.6z"/>
                                                <path fill-rule="evenodd" d="M2.832 13.228 8 9a1 1 0 1 0-1-1l-4.228 5.168-.026.086z"/>
                                              </svg></button>
                                        </form>
                                        <form action="/adPanel/quiz/{{ $video['Video'] }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="video" id="video" value="{{ $video['Video'] }}">
                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $video['Jurusan']) }}">
                                            <button class="btn btn-danger d-flex mt-2" onclick="return confirm('Are you sure?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                              </svg></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            </tbody>
            <script>
                function toggleTitle(el) {
                    el.className = el.className.includes('text-truncate') ? '' : 'text-truncate'
                }
            </script>
        </table>
@endsection