@extends('dashboard.layouts.main')

@section('container-top')
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
                    <form action="/dashboard/quiz/{{ request()->segment(count(request()->segments())) }}" method="post">
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
@endsection