@extends('dosPanel.layouts.main')

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
        <a href="/dosPanel/video/create">
            <button class="btn btn-primary" style="font-weight: 600;">Upload Video</button>
        </a>
        <form class="row" action="/dosPanel/video" method="post">
            @csrf
            <div class="input-group mb-3 w-50 ms-auto">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input name="search" id="search" type="text" class="form-control" placeholder="Cari Video disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}" required>
                <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
            </div>
            <a class="mb-3" href="/dosPanel/video" style="text-align: right;">Clear Search</a>
        </form>
    </div>
    <table class="table table-striped table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">Judul Video</th>
                <th scope="col">Fakultas</th>
                <th scope="col">Jurusan</th>
                <th scope="col">Harga</th>
                <th scope="col" style="text-align: center;">Edit</th>
            </tr>
        </thead>
        <tbody>
            @if($jurusan!=null)
                @if($search)
                    @foreach($jurusan as $vids)
                        @foreach($vids as $snapshot)
                            @if(Str::contains(Str::upper($snapshot['Judul_Video']), Str::upper($query)) || Str::contains(Str::upper($snapshot['Jurusan']), Str::upper($query)) || Str::contains(Str::upper($snapshot['Fakultas']), Str::upper($query)) || Str::contains(Str::upper($snapshot['Harga']),Str::upper($query)))
                            <tr>
                                <td>{{ $snapshot['Judul_Video'] }}</td>
                                <td>{{ $snapshot['Fakultas'] }}</td>
                                <td>{{ $snapshot['Jurusan'] }}</td>
                                <td>{{ $snapshot['Harga'] }}</td>
                                <td style="text-align: center;">
                                    <form action="/dosPanel/video/{{ $snapshot['Video'] }}/edit" method="post">
                                        @csrf
                                        <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                        <button class="btn btn-warning rounded-pill" style="text-align: center;">Edit</button>
                                    </form>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    @foreach($jurusan as $vids)
                        @foreach($vids as $snapshot)
                            <tr>
                                <td>{{ $snapshot['Judul_Video'] }}</td>
                                <td>{{ $snapshot['Fakultas'] }}</td>
                                <td>{{ $snapshot['Jurusan'] }}</td>
                                <td>{{ $snapshot['Harga'] }}</td>
                                <td style="text-align: center;">
                                    <form action="/dosPanel/video/{{ $snapshot['Video'] }}/edit" method="post">
                                        @csrf
                                        <input type="hidden" name="jurusan" id="jurusan" value="{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}">
                                        <button class="btn btn-warning rounded-pill" style="text-align: center;">Edit</button>
                                    </form>
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
    <script>
        function Choose(){
            document.getElementById('formJurusan').submit();
        }
        var divJurusan = document.getElementById('divJur').getElementsByTagName('optgroup');
        
        function showcategory(){
        var selectBox = document.getElementById('fakultas');
        var userInput = selectBox.options[selectBox.selectedIndex].value;
        var jurusanSelect = document.getElementById(userInput);
        for($m=0; $m < selectBox.options.length-1; $m++){
            if(divJurusan[$m].id == userInput){
                divJurusan[$m].style.display = '';
            } else{
                divJurusan[$m].style.display = 'none';
            }
        }
    }
    </script>
@endsection