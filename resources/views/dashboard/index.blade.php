@extends('dashboard.layouts.main')

@section('container-top')
    @include('dashboard.layouts.header')
    <div class="row">
        <div class="col-3">
            @include('dashboard.layouts.sidebar2')
        </div>
        <div class="col-9 border border-1 rounded shadow shadow-md p-4">
            <h3 style="color: #000C2E; font-weight: 700;">My Videos</h3>
            @if(Firebase::database()->getReference('users/'. Session::get('email') . '/vids')->getValue() != null)
            <div class="row">
            @foreach(Firebase::database()->getReference('users/'. Session::get('email') . '/vids')->getValue() as $data)
                <div class="col-4 mb-4 mx-5">
                    <div class="card" style="width: 334px;">
                        <div id="{{ $data['Video'] }}" style="text-align: center;"></div>
                        <div class="card-body">
                          <h5 class="card-title" style="color: #0038CF; font-weight: 800; font-family: Raleway;">{{ Str::title(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $data['Jurusan']) . '/' . $data['Video'])->getValue()['Judul_Video']) }}</h5>
                          <p class="card-text">{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $data['Jurusan']) . '/' . $data['Video'])->getValue()['Deskripsi'] }}</p>
                          <a href="/course/{{ Str::replace(' ', '_', Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $data['Jurusan']) . '/' . $data['Video'])->getValue()['Jurusan']) }}/{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $data['Jurusan']) . '/' . $data['Video'])->getValue()['Video'] }}" class="btn btn-primary" style="font-family: Raleway; font-weight: 500;">Watch Video</a>
                        </div>
                    </div>
                </div>
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
                            img.style = "height: 179px; width: 300px;";
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
                                "{{ asset('storage/' . Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $data['Jurusan']) . '/' . $data['Video'])->getValue()['Link']) }}",
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
        @endforeach
    </div>
    @else
        <h1 class="text-center">You don't have any videos yet</h1>
    @endif
        </div>
    </div>
@endsection