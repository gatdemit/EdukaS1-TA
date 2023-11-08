@extends('layouts.main')

<div class="container">
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
        <main class="col-md9 col-lg-10">
            <div class="d-flex align-items-center border bg-body-tertiary">
                @if(Str::contains(Str::replace('_',' ', request()->segment(count(request()->segments()))), $jurusan))
                    @foreach($videos as $snapshot)
                        @if($snapshot['Jurusan']==Str::replace('_',' ', request()->segment(count(request()->segments()))))
                            <div class="card my-3 pb-3">
                                @if(Session::get('user'))
                                <form action="/keranjang" method="post">
                                    @csrf        
                                    <div class="col">
                                        <a href="/course/{{ $snapshot['Jurusan'] }}/{{ $snapshot['Video'] }}">
                                            <div id="{{ $snapshot['Video'] }}"></div>
                                            <input type="hidden" name="judul" id="judul" value="{{ $snapshot['Judul_Video'] }}">
                                            <input type="hidden" name="harga" id="harga" value="{{ $snapshot['Harga'] }}">
                                            <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                            <input type="hidden" name="fakultas" id="fakultas" value="{{ $snapshot['Fakultas'] }}">
                                            <input type="hidden" name="jurusan" id="jurusan" value="{{ $snapshot['Jurusan'] }}">
                                            <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                            <h1>ini {{ $snapshot['Judul_Video'] }}</h1>
                                            <p>ini {{ $snapshot['Fakultas'] }}</p>
                                            <p>ini {{ $snapshot['Jurusan'] }}</p>
                                            <p>ini {{ $snapshot['Harga'] }}</p>
                                            <p>ini {{ $snapshot['Deskripsi'] }}</p>
                                        </a>
                                    </div>
                                    @if(!Firebase::database()->getReference('users/' . Session::get('email') . '/vids/' . $snapshot['Video'])->getSnapshot()->exists())
                                        <div class="col">
                                            <button class="btn btn-primary">Beli</button>
                                        </div>
                                    @endif
                                </form>
                                @else
                                <div class="col">
                                    <a href="/course/{{ $snapshot['Jurusan'] }}/{{ $snapshot['Video'] }}">
                                        <h1>ini {{ $snapshot['Judul_Video'] }}</h1>
                                        <p>ini {{ $snapshot['Fakultas'] }}</p>
                                        <p>ini {{ $snapshot['Jurusan'] }}</p>
                                        <p>ini {{ $snapshot['Harga'] }}</p>
                                        <p>ini {{ $snapshot['Deskripsi'] }}</p>
                                        @if(Firebase::database()->getReference('videos/' . $snapshot['Video'] . '/rating')->getSnapshot()->exists())
                                            <p>Rating: {{ $snapshot['rating']/$snapshot['rate_count'] }}</p>
                                        @else
                                            <p>Rating: 0</p>
                                        @endif
                                        @if(Firebase::database()->getReference('videos/' . $snapshot['Video'] . '/buy_count')->getSnapshot()->exists())
                                            <p>Dibeli: {{ $snapshot['buy_count'] }} user</p>
                                        @else
                                            <p>Dibeli: 0 user</p>
                                        @endif
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="btn btn-primary" href="/login">Login untuk beli</a>
                                </div>
                                @endif
                            </div>
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
                                    img.style = "height: 86px; width:86px; max-height:86px; max-width:86px;";
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
                                        "{{ asset('storage/' . Firebase::database()->getReference('videos/' . $snapshot['Video'])->getValue()['Link']) }}",
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
                    <h1>Course doesn't exist</h1>
                @endif
            </div>
        </main>
    </div>
</div>






