@extends('dashboard.layouts.main')

@section('container')

  <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-0">Full Name</p>
          </div>
          <div class="col-sm-9">
            <p class="text-muted mb-0">{{ Str::title(Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['name']) }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-0">Username</p>
          </div>
          <div class="col-sm-9">
            <p class="text-muted mb-0">{{ Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['username'] }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-0">Phone Number</p>
          </div>
          <div class="col-sm-9">
            <p class="text-muted mb-0">{{ Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['nomor_telp'] }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-0">Jenis Kelamin</p>
          </div>
          <div class="col-sm-9">
            <p class="text-muted mb-0">{{ Str::title(Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['gender']) }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-0">Tanggal Lahir</p>
          </div>
          <div class="col-sm-9">
            <p class="text-muted mb-0">{{ Carbon\Carbon::parse(Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['tanggal_lahir'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('jS F Y') }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-0">Address</p>
          </div>
          <div class="col-sm-9">
            <p class="text-muted mb-0">{{ Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['alamat'] }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <h3 style="color: #000C2E; font-weight: 700;">My Videos</h3>
            @if(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getSnapshot()->exists())
                <div class="row">
                    @foreach(Firebase::database()->getReference('users/' . Session::get('email') . '/vids')->getValue() as $vids)
                        <div class="col-4 mb-4 mx-5">
                            <div class="card" style="width: 334px;">
                                <div id="{{ $vids['Video'] }}" style="text-align: center;"></div>
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #0038CF; font-weight: 800; font-family: Raleway;">{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Judul_Video'] }}</h5>
                                    <p class="card-text">{{ Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Deskripsi'] }}</p>
                                    <a href="/course/{{ Str::replace(' ', '_', $vids['Jurusan']) }}/{{ $vids['Video']}}" class="btn btn-primary" style="font-family: Raleway; font-weight: 500;">Watch Video</a>
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
                                            "{{ asset('storage/' . Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $vids['Jurusan']) . '/' . $vids['Video'])->getValue()['Link']) }}",
                                            0,
                                            function(img, secs, event) {
                                                if (event.type == 'seeked') {
                                                    document.getElementById("{{ $vids['Video'] }}").appendChild(img);
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
                </div>
            @else
                You don't have any videos
            @endif
        </div>
    </div>
  </div>
@endsection