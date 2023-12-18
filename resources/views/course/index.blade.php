@extends('layouts.main')

@section('container')

<style>
  .hover-primary:hover {
    background-color: #3B71CA;
    color: white;
  }
</style>

<div class="container">
  <div class="row my-5">
    <div class="col-12 bold mb-5 text-dark" style="font-size: 36px; font-weight: 600; text-align:center; color: #101828">
      Selamat Datang Di Pusat Kursus Edukas1!
    </div>
  </div>
  <div class="row mt-5">
    @foreach($fakultas as $facs)
      <div class="col-3 my-4"  style='width: 375px;' id="div{{ $facs['Value'] }}">
        <div class="card shadow shadow-lg">
          <button type="button" data-bs-toggle="modal" data-bs-target="#{{ Str::replace(' ', '', $facs['Value']) }}" class="btn">
            <img src="https://source.unsplash.com/300x300/?{{ $facs['Value'] }}" class="img-preview" style="max-height:300px; max-width:100%;" role="button" id="myfile" name="myfile">
            <div role="button" class="card-body" style="text-align: left;">
              @if($facs['Value'] == 'Umum')
                <p class="bold">Mata Kuliah {{ $facs['Value'] }}</p>
              @else
                <p class="bold">Fakultas {{ $facs['Value'] }}</p>
              @endif
              <p style="font-weight: 500;">Kunjungi ></p>
            </div>
          </button>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="{{ Str::replace(' ','',$facs['Value']) }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Fakultas {{ $facs['Value'] }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal{{ $facs['Value'] }}">
              @foreach($facs['jurusan'] as $jurusan)
                @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $jurusan))->getSnapshot()->exists())
                  <a href="/course/{{ Str::replace(' ','_',$jurusan) }}">
                    <p>
                      {{ $jurusan }}
                    </p>
                  </a>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <!--End Modal-->
      <script>
        var div = document.getElementById("div{{ $facs['Value'] }}");
        var modal = document.getElementById("modal{{ $facs['Value'] }}");
        console.log(modal.children.length <= 0);
        if(modal.children.length <= 0){
          div.style.display="none";
        }
      </script>
    @endforeach
  </div>
</div>

@endsection
