@extends('dashboard.layouts.main')

@section('container')
        <div class="card mb-4">
            <div class="card-body">
                @if($jurusan == null || request()->segment(count(request()->segments())) > Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis')->getSnapshot()->numChildren())
                    Tidak ada lagi pertanyaan
                @else
                <h3 class="text-center" style="color: #000C2E; font-weight: 700;">Quiz <span class="text-primary"> - {{ Str::title(Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1))->getValue()['Judul_Video']) }}</span></h3>
                <h5 class="text-center mb-3" style="color: #000C2E; font-weight: 700;">Pertanyaan</h5>
                <div class="row justify-content-between">
                    @for($i = 1; $i <= Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis')->getSnapshot()->numChildren(); $i++)
                        <div class="col-2" style="text-align: center">
                            <form action="/dashboard/quiz/{{ request()->segment(count(request()->segments())-1) }}/{{ $i }}" method="post">
                                @csrf
                                <input type="hidden" name="jur" id="jur" value="{{ $jurusan }}">
                                <button class="card m-4">
                                    <div class="card-body">
                                        {{ $i }}
                                    </div>
                                </button>
                            </form>
                        </div>
                        @if($i % 5 == 0)
                            <div class="w-100"></div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
        <div class="card mb-4 p-4">
            <div class="card-body">
                @if(session()->has('error'))
                    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                    <form action="/dashboard/quiz{{ request()->segment(count(request()->segments())) == Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis')->getSnapshot()->numChildren() ? '/' . request()->segment(count(request()->segments())-1) : '/' . request()->segment(count(request()->segments())-1) . '/' . request()->segment(count(request()->segments())) + 1 }}" method="post">
                        @csrf
                        <p class="text-muted" style="font-family: Raleway;">Pertanyaan {{ request()->segment(count(request()->segments())) }}</p>
                        
                        <h5 style="font-family: Raleway; font-weight: 800;">{{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis/pertanyaan ' . request()->segment(count(request()->segments())))->getValue()['pertanyaan'] }}</h5>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="Pertanyaan_{{ request()->segment(count(request()->segments())) }}" id="radio1" value ="jawaban 1" {{ Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) != null && Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) == 'jawaban 1' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                                {{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis/pertanyaan ' . request()->segment(count(request()->segments())))->getValue()['jawaban']['jawaban 1'] }}
                            </label>
                        </div>
                
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="Pertanyaan_{{ request()->segment(count(request()->segments())) }}" id="radio1" value="jawaban 2" {{ Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) != null && Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) == 'jawaban 2' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                                {{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis/pertanyaan ' . request()->segment(count(request()->segments())))->getValue()['jawaban']['jawaban 2'] }}
                            </label>
                        </div>
                
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="Pertanyaan_{{ request()->segment(count(request()->segments())) }}" id="radio1" value="jawaban 3" {{ Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) != null && Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) == 'jawaban 3' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                                {{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis/pertanyaan ' . request()->segment(count(request()->segments())))->getValue()['jawaban']['jawaban 3'] }}
                            </label>
                        </div>
                
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="Pertanyaan_{{ request()->segment(count(request()->segments())) }}" id="radio1" value="jawaban 4" {{ Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) != null && Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) == 'jawaban 4' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                                {{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis/pertanyaan ' . request()->segment(count(request()->segments())))->getValue()['jawaban']['jawaban 4'] }}
                            </label>
                        </div>
                
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="Pertanyaan_{{ request()->segment(count(request()->segments())) }}" id="radio1" value="jawaban 5" {{ Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) != null && Cache::get('Pertanyaan_' . request()->segment(count(request()->segments()))) == 'jawaban 5' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio1" style="font-family: Raleway; font-weight: 700;">
                                {{ Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis/pertanyaan ' . request()->segment(count(request()->segments())))->getValue()['jawaban']['jawaban 5'] }}
                            </label>
                        </div>
                        <input type="hidden" name="jur" id="jur" value="{{ $jurusan }}">
                        <input type="hidden" name="pertanyaan" id="pertanyaan" value="{{ request()->segment(count(request()->segments())) }}">
                        <button class="btn btn-primary m-auto d-block" style="font-family: Raleway; font-weight: 500;">{{ request()->segment(count(request()->segments())) == Firebase::database()->getReference('videos/' . $jurusan . '/' . request()->segment(count(request()->segments())-1) . '/kuis')->getSnapshot()->numChildren() ? 'Submit' : 'Next' }}</button>
                    </form>
                @endif
            </div>
        </div>
@endsection