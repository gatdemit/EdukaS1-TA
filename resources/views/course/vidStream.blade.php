@extends('layouts.main')

@section('container')
    <div class="row">
        @if(Session::get('user'))
            @if(Firebase::database()->getReference('users/'. Session::get('email') . '/vids/' . request()->segment(count(request()->segments())))->getSnapshot()->exists())
                <div style="margin: 0 auto; width: 500px; padding: 20px;">
                    <video width="320" height="240" style="width:100%;" controls id="video">
                        <source src="{{ asset('storage/'. Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Link']) }}" type="video/mp4">
                    </video>
                </div>
                <h1>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Judul_Video'] }}</h1>
                <p>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Deskripsi'] }}</p>
                
                <form action="/rate" method="POST">
                    @csrf
                    <input type="hidden" name="link" id="link" value="{{ request()->segment(count(request()->segments())) }}">
                    <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                    <div class="col">
                        <div class="rate">
                           <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                           <label for="star5" title="text">5 stars</label>
                           <input type="radio" checked id="star4" class="rate" name="rating" value="4"/>
                           <label for="star4" title="text">4 stars</label>
                           <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                           <label for="star3" title="text">3 stars</label>
                           <input type="radio" id="star2" class="rate" name="rating" value="2">
                           <label for="star2" title="text">2 stars</label>
                           <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                           <label for="star1" title="text">1 star</label>
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
                    @if(!Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())) . '/rating')->getSnapshot()->exists())
                        <small>(0)</small>
                    @else
                        <small>({{ Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())))->getValue()['rating']/Firebase::database()->getReference('videos/' . request()->segment(count(request()->segments())))->getValue()['rate_count'] }})</small>
                    @endif
                    <button class="btn btn-primary">Rate us!</button>
                </form>
                <a href="/dashboard/quiz/{{ request()->segment(count(request()->segments())) }}" class="btn btn-success">Kerjakan Quiz</a>
            @endif
            @if(!Firebase::database()->getReference('users/' . Session::get('email') . '/vids/' . request()->segment(count(request()->segments())))->getSnapshot()->exists())
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
                <div id="vidDiv" style="margin: 0 auto; width: 500px; padding: 20px;">
                    <button class="btn btn-success" id="replayBtn" style="display:none;" onclick="enable()">Putar Ulang</button>
                    <video width="320" height="240" id="video" style="width:100%;" controls> 
                        <source src="{{ asset('storage/'. Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Link']) }}" type="video/mp4">
                    </video>
                </div>
                <h1>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Judul_Video'] }}</h1>
                <p>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Deskripsi'] }}</p>
                <form action="/keranjang" method="POST">
                    @csrf
                    <input type="hidden" name="judul" id="judul" value="{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Judul_Video'] }}">
                    <input type="hidden" name="harga" id="harga" value="{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Harga'] }}">
                    <input type="hidden" name="video" id="video" value="{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Video'] }}">
                    <input type="hidden" name="fakultas" id="fakultas" value="{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Fakultas'] }}">
                    <input type="hidden" name="jurusan" id="jurusan" value="{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Jurusan'] }}">
                    <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                    <button class="btn btn-primary">Beli Video</button>
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
        <div id="vidDiv" style="margin: 0 auto; width: 500px; padding: 20px;">
            <button class="btn btn-success" id="replayBtn" style="display:none;" onclick="enable()">Putar Ulang</button>
            <video width="320" height="240" id="video" style="width:100%;" controls> 
                <source src="{{ asset('storage/'. Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Link']) }}" type="video/mp4">
            </video>
        </div>
        <h1>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Judul_Video'] }}</h1>
        <p>{{ Firebase::database()->getReference('videos/'. request()->segment(count(request()->segments())))->getValue()['Deskripsi'] }}</p>
        <a href="/login" class="btn btn-primary">Login untuk Beli</a>    
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