@extends('layouts.main')

@section('container')
    
<div class="container">

    <!-- Hero -->
    <div class="p-5 mb-4 text-center bg-image rounded-3" style="
    background-image: url('{{ asset('storage/asset/header.jpeg') }}'); background-size: cover;
    height: 300px;
    ">
        <div class="row">
            <h1 class="col bold" style="text-align: left; color: black;">
                Enhance your skills <br> through videos <br> online offered by <br> Edukas<span style="color: #0038CF">1</span>
            </h1>
            <div class="col">

            </div>
        </div>
    </div>

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
    <div class="row">
        <main>
            <div class="row d-flex align-items-between">
                <div class="row mb-5">
                    <div class="col" style="font-size: 36px; text-align:center;">
                        <div class="row bold" style="color: #0038CF;">
                            {{ Str::replace('_', ' ', request()->segment(count(request()->segments()))) }}
                        </div>
                        <div class="mb-4 row" style="text-align: left; font-size: 16px;">
                            {{ $fakultas['Deskripsi'][request()->segment(count(request()->segments()))]['Value'] }}
                        </div>
                    </div>
                    
                    <div class="col">
                        <form action="/course/{{ request()->segment(count(request()->segments())) }}" method="post">
                            @csrf
                            <div class="input-group col-12 m-auto mb-5 w-50">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input id="search" name="search" type="text" class="form-control" placeholder="Cari Video disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                                <button class="btn btn-primary">Cari</button>
                                <a class="mb-5" href="/course/{{ request()->segment(count(request()->segments())) }}" style="text-align:center;">Clear Search</a>
                            </div>
                        </form>
                    </div>
                </div>
                

                @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())))->getSnapshot()->exists())
                    @if($search)
                        @foreach(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) )->getValue() as $key => $snapshot)
                            @if($snapshot['Jurusan']==Str::replace('_',' ', request()->segment(count(request()->segments()))))
                                @if(Str::contains($snapshot['Judul_Video'], $query) || Str::contains($snapshot['Deskripsi'], $query))
                                    @if($snapshot['Active'])
                                        <div class="col-3 my-4 mx-4">
                                        <div class="card shadow shadow-lg" style="width: 300px;">
                                            @if(Session::get('user'))
                                                <form action="/keranjang" method="post">
                                                    @csrf
                                                    <a href="/course/{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}/{{ $snapshot['Video']}}" class="nav-link">
                                                        <div id="{{ $snapshot['Video'] }}"></div>
                                                        <div class="card-body">
                                                            <input type="hidden" name="judul" id="judul" value="{{ $snapshot['Judul_Video'] }}">
                                                            <input type="hidden" name="harga" id="harga" value="{{ $snapshot['Harga'] }}">
                                                            <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                                            <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Fakultas'] }}">
                                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ $snapshot['Jurusan'] }}">
                                                            <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                                            <h5 class="card-title bold text-primary text-truncate" id="extended-title-{{$key}}">{{ Str::title($snapshot['Judul_Video']) }}</h5>
                                                            <a class="link-opacity-50 text-small text-muted" style="font-size: 0.875rem" href="javascript:void(0)" onclick="toggleItem('<?= $key ?>')">extend</a>
                                                            <div style="display: none" id="extended-info-{{$key}}">
                                                                {{ $snapshot['Deskripsi'] }}<br><br>
                                                                @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/rating')->getSnapshot()->exists())
                                                                    Rating: {{ $snapshot['rating']/$snapshot['rate_count'] }} ({{ $snapshot['rate_count'] }} Users)<br>
                                                                @else
                                                                    Rating: 0<br>
                                                                @endif
                                                                @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/buy_count')->getSnapshot()->exists())
                                                                    Dibeli: {{ $snapshot['buy_count'] }} user<br>
                                                                @else
                                                                    Dibeli: 0 user<br>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="span">
                                                                    Rp {{ $snapshot['Harga'] }}
                                                                </div>
                                                                @if(!Firebase::database()->getReference('users/' . Session::get('email') . '/vids/' . $snapshot['Video'])->getSnapshot()->exists())
                                                                    <button class="btn btn-primary h-100">Add to Cart</button>
                                                                @else
                                                                    <a href="/course/{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}/{{ $snapshot['Video']}}" class="btn btn-primary h-100">Watch</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </form>
                                            @else
                                                <a href="/course/{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}/{{ $snapshot['Video']}}" class="nav-link">
                                                    <div id="{{ $snapshot['Video'] }}"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title bold text-primary text-truncate" id="extended-title-{{$key}}">{{ Str::title($snapshot['Judul_Video']) }}</h5>
                                                        <a class="link-opacity-50 text-small text-muted" style="font-size: 0.875rem" href="javascript:void(0)" onclick="toggleItem('<?= $key ?>')">extend</a>
                                                        <div style="display: none" id="extended-info-{{$key}}">
                                                            {{ $snapshot['Deskripsi'] }}<br><br>
                                                            @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/rating')->getSnapshot()->exists())
                                                                Rating: {{ $snapshot['rating']/$snapshot['rate_count'] }} ({{ $snapshot['rate_count'] }} Users)<br>
                                                            @else
                                                                Rating: 0<br>
                                                            @endif
                                                            @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/buy_count')->getSnapshot()->exists())
                                                                Dibeli: {{ $snapshot['buy_count'] }} user<br>
                                                            @else
                                                                Dibeli: 0 user<br>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div class="span">
                                                                Rp {{ $snapshot['Harga'] }}
                                                            </div>
                                                            <a href="/login" class="btn btn-primary h-100">Login untuk Beli</a>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                        </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                            <script>
                                function getVideoImage(path, secs, callback) {
                                    var me = this, video = document.createElement('video');
                                    video.onloadedmetadata = function() {
                                        if ('function' === typeof secs) {
                                        secs = secs(this.duration);
                                        }
                                        this.currentTime = Math.min(Math.max(0, (secs < 0 ? this.duration : 0) + secs), this.duration);
                                    };
                                    video.onseeked = function(e) {
                                        var canvas = document.createElement('canvas');
                                        canvas.height = video.videoHeight;
                                        canvas.width = video.videoWidth;
                                        var ctx = canvas.getContext('2d');
                                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                                        var img = new Image();
                                        img.src = canvas.toDataURL();
                                        img.style = "height:179px; width:300px;";
                                        callback.call(me, img, this.currentTime, e);
                                    };
                                    video.onerror = function(e) {
                                        callback.call(me, undefined, undefined, e);
                                    };
                                    video.src = path;
                                    }
    
                                    function showImageAt(secs) {
                                        var duration;
                                        getVideoImage(
                                            "{{ asset('storage/' . Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] )->getValue()['Link']) }}",
                                            0,
                                            function(img, secs, event) {
                                                if (event.type == 'seeked') {
                                                    document.getElementById("{{ $snapshot['Video'] }}").appendChild(img);
                                                    if (duration >= ++secs) {
                                                        showImageAt(secs);
                                                    };
                                                }
                                            }
                                        );
                                    }
                                    showImageAt(0);
                            </script>
                        @endforeach
                    @else
                        @foreach(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) )->getValue() as $key =>$snapshot)
                            @if($snapshot['Jurusan']==Str::replace('_',' ', request()->segment(count(request()->segments()))))
                                @if($snapshot['Active'])
                                    <div class="col-3 mb-4 mx-4">
                                        <div class="card shadow shadow-lg" style="width: 300px;">
                                            @if(Session::get('user'))
                                                <form action="/keranjang" method="post">
                                                    @csrf
                                                    <a href="/course/{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}/{{ $snapshot['Video']}}" class="nav-link">
                                                        <div id="{{ $snapshot['Video'] }}"></div>
                                                        <div class="card-body">
                                                            <input type="hidden" name="judul" id="judul" value="{{ $snapshot['Judul_Video'] }}">
                                                            <input type="hidden" name="harga" id="harga" value="{{ $snapshot['Harga'] }}">
                                                            <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                                            <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Fakultas'] }}">
                                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ $snapshot['Jurusan'] }}">
                                                            <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                                            <h5 class="card-title bold text-primary text-truncate" id="extended-title-{{$key}}">{{ Str::title($snapshot['Judul_Video']) }}</h5>
                                                            <a class="link-opacity-50 text-small text-muted" style="font-size: 0.875rem" href="javascript:void(0)" onclick="toggleItem('<?= $key ?>')">extend</a>
                                                            <div style="display: none" id="extended-info-{{$key}}">
                                                                {{ $snapshot['Deskripsi'] }}<br><br>
                                                                @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/rating')->getSnapshot()->exists())
                                                                    Rating: {{ $snapshot['rating']/$snapshot['rate_count'] }} ({{ $snapshot['rate_count'] }} Users)<br>
                                                                @else
                                                                    Rating: 0<br>
                                                                @endif
                                                                @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/buy_count')->getSnapshot()->exists())
                                                                    Dibeli: {{ $snapshot['buy_count'] }} user<br>
                                                                @else
                                                                    Dibeli: 0 user<br>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="span">
                                                                    Rp {{ $snapshot['Harga'] }}
                                                                </div>
                                                                @if(!Firebase::database()->getReference('users/' . Session::get('email') . '/vids/' . $snapshot['Video'])->getSnapshot()->exists())
                                                                    <button class="btn btn-primary h-100">Add to Cart</button>
                                                                @else
                                                                    <a href="/course/{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}/{{ $snapshot['Video']}}" class="btn btn-primary h-100">Watch</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </form>
                                            @else
                                                <a href="/course/{{ Str::replace(' ', '_', $snapshot['Jurusan']) }}/{{ $snapshot['Video']}}" class="nav-link">
                                                    <div id="{{ $snapshot['Video'] }}"></div>
                                                    <div class="card-body">
                                                        <h5 class="card-title bold text-primary text-truncate" id="extended-title-{{$key}}">{{ Str::title($snapshot['Judul_Video']) }}</h5>
                                                        <a class="link-opacity-50 text-small text-muted" style="font-size: 0.875rem" href="javascript:void(0)" onclick="toggleItem('<?= $key ?>')">extend</a>
                                                        <div style="display: none" id="extended-info-{{$key}}">
                                                            {{ $snapshot['Deskripsi'] }}<br><br>
                                                            @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/rating')->getSnapshot()->exists())
                                                                Rating: {{ $snapshot['rating']/$snapshot['rate_count'] }} ({{ $snapshot['rate_count'] }} Users)<br>
                                                            @else
                                                                Rating: 0 <br>
                                                            @endif
                                                            @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] . '/buy_count')->getSnapshot()->exists())
                                                                Dibeli: {{ $snapshot['buy_count'] }} user <br>
                                                            @else
                                                                Dibeli: 0 user <br>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <div class="span">
                                                                Rp {{ $snapshot['Harga'] }}
                                                            </div>
                                                            <a href="/login" class="btn btn-primary h-100">Login untuk Beli</a>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <script>
                                function getVideoImage(path, secs, callback) {
                                    var me = this, video = document.createElement('video');
                                    video.onloadedmetadata = function() {
                                        if ('function' === typeof secs) {
                                        secs = secs(this.duration);
                                        }
                                        this.currentTime = Math.min(Math.max(0, (secs < 0 ? this.duration : 0) + secs), this.duration);
                                    };
                                    video.onseeked = function(e) {
                                        var canvas = document.createElement('canvas');
                                        canvas.height = video.videoHeight;
                                        canvas.width = video.videoWidth;
                                        var ctx = canvas.getContext('2d');
                                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                                        var img = new Image();
                                        img.src = canvas.toDataURL();
                                        img.style = "height:179px; width:300px;";
                                        callback.call(me, img, this.currentTime, e);
                                    };
                                    video.onerror = function(e) {
                                        callback.call(me, undefined, undefined, e);
                                    };
                                    video.src = path;
                                    }

                                    function showImageAt(secs) {
                                        var duration;
                                        getVideoImage(
                                            "{{ asset('storage/' . Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/' . $snapshot['Video'] )->getValue()['Link']) }}",
                                            0,
                                            function(img, secs, event) {
                                                if (event.type == 'seeked') {
                                                    document.getElementById("{{ $snapshot['Video'] }}").appendChild(img);
                                                    if (duration >= ++secs) {
                                                        showImageAt(secs);
                                                    };
                                                }
                                            }
                                        );
                                    }
                                    showImageAt(0);
                            </script>
                        @endforeach
                    @endif
                @else
                Course Doesn't Exist
                @endif
            </div>
        </main>
    </div>
    <script>
        function toggleItem(id) {
            var element = document.getElementById('extended-info-' + id);
            element.style.display = (element.style.display === 'none' || element.style.display === '') ? 'block' : 'none';

            element = document.getElementById('extended-title-' + id);
            element.className = element.className === "card-title text-primary text-truncate" ? "card-title text-primary" : "card-title text-primary text-truncate"
        }
    </script>
</div>

@endsection







