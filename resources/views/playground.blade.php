<!doctype html>
<html lang="en">
  <head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    {{-- Booststrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Raleway:wght@400;500;700;800&display=swap&family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">

    {{-- My CSS --}}
    <link href="/css/style.css" rel="stylesheet">


    <style>
      * {
          font-family: Inter;
      }

      table * {
          font-family: Montserrat;
      }

      .ff-raleway {
          font-family: Raleway;
          font-weight: bold;
      }

      
    </style>
    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    
    <header class="row px-5 pb-5 mt-2">
        <div class="d-flex justify-content-between">
            <div>
              <a href="/" class="nav-link fw-bold ff-inter" style="font-size: 34px;">Edukas<span style="color: #0038CF">1</span></a>
            </div>
            <div>
                @include("partials.navbar")
            </div>
        </div>
    </header>

    <main class="row px-5 pb-5">
      <div class="row">
        <div class="col-lg-4">
            <div class="card overflow-auto" style="max-height: 30%;">
                <div class="card-header">
                    <h5 style="font-weight: 700;">Categories</h5>
                </div>
                <br>
                @foreach($fakultas as $facs)
                    <div class="card-body" id="heading{{ $facs['Value'] }}">
                        <h5 class="mb-0">
                            <button class="btn nav-link" data-bs-toggle="collapse" data-bs-target="#{{ Str::replace(' ', '_', $facs['Value']) }}" aria-expanded="true" aria-controls="{{ Str::replace(' ', '_', $facs['Value']) }}" style="font-size: 16px;">
                            Fakultas {{ $facs['Value'] }}
                            </button>
                        </h5>
                    </div>
                
                    <div id="{{ Str::replace(' ', '_', $facs['Value']) }}" class="collapse" aria-labelledby="heading{{ $facs['Value'] }}" data-parent="#accordion">
                        <div class="mx-5">
                            @foreach($facs['jurusan'] as $jurusan)
                                <a class="nav-link" href="/course/{{ Str::replace(' ','_',$jurusan) }}">{{ $jurusan }}</a>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
                <div class="container m-auto w-100 rounded p-5 text-center" style="background-color: #d4dcfc;">
                    <div id="vidDiv" style="margin: 0 auto; width: 500px; padding: 20px;">
                        <button class="btn btn-success" id="replayBtn" style="display:none;" onclick="enable()">Putar Ulang</button>
                        <video width="400" height="300" controls id="video">
                            <source src="{{ asset('storage/'. Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Link']) }}" type="video/mp4">
                        </video>
                    </div>
                    <h3 class="my-5" style="font-family: Raleway; font-weight: 800; color: #0038CF;">{{ Str::title(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Judul_Video']) }}</h3>
                    <p style="font-family: Raleway;">{{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Deskripsi'] }}</p>
                        
                    @if(Session::get('user'))
                        @if(Firebase::database()->getReference('users/'. Session::get('email') . '/vids/' . request()->segment(count(request()->segments())))->getSnapshot()->exists())
                            <form action="/rate" method="POST" class="text-warning">
                                @csrf
                                <input type="hidden" name="link" id="link" value="{{ request()->segment(count(request()->segments())) }}">
                                <input type="hidden" name="jurusan" id="jurusan" value="{{ request()->segment(count(request()->segments())-1) }}">
                                <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                <div class="row">
                                    <div class="col">
                                        <div class="rate">
                                        <input type="radio" id="star5" class="rate" name="rating" value="5" checked/>
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" class="rate" name="rating" value="4"/>
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" class="rate" name="rating" value="2">
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                        <label for="star1" title="text">1 star</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())) . '/rate_count')->getSnapshot()->exists())
                                            <p style="font-family: Raleway; font-weight: 600; color: #230F0F;">
                                                ({{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['rate_count'] }} Reviews)
                                            </p>
                                        @else
                                            <p style="font-family: Raleway; font-weight: 600; color: #230F0F;">
                                                (0 Reviews)
                                            </p>
                                        @endif
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
                                <div class="row justify-content-start">
                                    <div class="col-md-2">
                                        <button class="btn btn-primary m-auto d-block mt-5" style="font-family: Raleway; font-weight: 500;">Rate us!</button>
                                    </div>
                                </div>
                            </form>
                            @if(Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())) . '/kuis')->getSnapshot()->exists())
                                <form action="/dashboard/quiz/{{ request()->segment(count(request()->segments())) }}/1" method="post">
                                    @csrf
                                    <input type="hidden" name="jur" id="jur" value={{ request()->segment(count(request()->segments())-1) }}>
                                    <button class="btn btn-primary m-auto d-block mt-5" style="font-family: Raleway; font-weight: 500;">Kerjakan Quiz</button>
                                </form>
                            @else
                                <div style="font-family: Raleway; font-weight: 600;">
                                    Kuis Belum Dibuat
                                </div>
                            @endif
                        @elseif(!Firebase::database()->getReference('users/' . Session::get('email') . '/vids/' . request()->segment(count(request()->segments())))->getSnapshot()->exists())
                            <form action="/keranjang" method="POST">
                                @csrf
                                <input type="hidden" name="judul" id="judul" value="{{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Judul_Video'] }}">
                                <input type="hidden" name="harga" id="harga" value="{{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Harga'] }}">
                                <input type="hidden" name="video" id="video" value="{{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Video'] }}">
                                <input type="hidden" name="fakultas" id="fakultas" value="{{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Fakultas'] }}">
                                <input type="hidden" name="jurusan" id="jurusan" value="{{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Jurusan'] }}">
                                <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                <p style="font-family: Raleway;">Harga: Rp {{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())))->getValue()['Harga'] }}</p>
                                <button class="btn btn-primary m-auto d-block mt-5" style="font-family: Raleway; font-weight: 500;">Beli Video</button>
                            </form>
                        <script>
                            var vid = document.getElementById('video');
                            var replayBtn = document.getElementById('replayBtn');
                            var vidDiv = document.getElementById('vidDiv');        
                            vid.addEventListener('timeupdate', function(){
                            if(this.currentTime >= 5){
                                vidDiv.classList.add("layar");
                                replayBtn.style.display="block";
                                this.pause();
                                this.controls=false;
                            }
                            });
            
                            function enable(){
                            replayBtn.style.display='none';
                            vidDiv.classList.remove('layar');
                            vid.controls=true;
                            vid.currentTime = 0;
                            };
                        </script>
                        @endif
                    @else
                    <a href="/login" class="btn btn-primary mt-5" style="font-family: Raleway; font-weight: 500;">Login untuk Beli</a>  
                    <script>
                        var vid = document.getElementById('video');
                        var replayBtn = document.getElementById('replayBtn');
                        var vidDiv = document.getElementById('vidDiv');        
                        vid.addEventListener('timeupdate', function(){
                        if(this.currentTime >= 5){
                            vidDiv.classList.add("layar");
                            replayBtn.style.display="block";
                            this.pause();
                            this.controls=false;
                        }
                        });
            
                        function enable(){
                        replayBtn.style.display='none';
                        vidDiv.classList.remove('layar');
                        vid.controls=true;
                        vid.currentTime = 0;
                        };
                    </script>
                    @endif
                </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="row mt-5 pt-5">
      @include('layouts.footer')
    </footer>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js" integrity="sha384-gdQErvCNWvHQZj6XZM0dNsAoY4v+j5P1XDpNkcM3HJG1Yx04ecqIHk7+4VBOCHOG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>