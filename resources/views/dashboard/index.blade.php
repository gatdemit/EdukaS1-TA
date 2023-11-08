@extends('dashboard.layouts.main')

@section('container-header')
    <h1>Welcome, {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['username'] }}</h1>
@endsection

@section('container-top')
    @include('dashboard.layouts.header')
    @include('dashboard.layouts.sidebar')
@endsection

@section('container-main')
    @if(Firebase::database()->getReference('users/'. Session::get('email') . '/vids')->getValue() != null)
        @foreach(Firebase::database()->getReference('users/'. Session::get('email') . '/vids')->getValue() as $data)
            <div class="card my-3 pb-3">
                <a href="/course/{{ $data['Jurusan'] }}/{{ $data['Video'] }}">
                    <div id="{{ $data['Video'] }}"></div>
                    <h5>{{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Judul_Video'] }}</h5>
                    <p>Fakultas: {{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Fakultas'] }}</p>
                    <p>Jurusan: {{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Jurusan'] }}</p>
                    <p>{{ Firebase::database()->getReference('videos/'. $data['Video'])->getValue()['Deskripsi'] }}</p>
                </a>
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
                                "{{ asset('storage/' . Firebase::database()->getReference('videos/' . $data['Video'])->getValue()['Link']) }}",
                                0,
                                function(img, secs, event) {
                                    if (event.type == 'seeked') {
                                        document.getElementById("{{ $data['Video'] }}").appendChild(img);
                                        if (duration >= ++secs) {
                                            showImageAt(secs);
                                        };
                                    }
                                }
                            );
                        }
                        showImageAt(0);
                </script>
            </div>
        @endforeach
    @else
        <h1>You don't have any videos yet</h1>
    @endif
@endsection
