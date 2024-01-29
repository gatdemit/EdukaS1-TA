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
    <div class="col-12 bold mb-5" style="font-size: 36px; text-align: center; color: #0038CF;">
      Selamat Datang Di Pusat Kursus Edukas1!
    </div>
  </div>
  <div class="d-flex flex-wrap mt-5">
    @foreach($fakultas as $facs)
    <div class="mx-4 my-4" style='width: 375px;' id="div{{ $facs['Value'] }}">
      <div class="card shadow shadow-lg">
        <button type="button" data-bs-toggle="modal" data-bs-target="#{{ Str::replace(' ', '', $facs['Value']) }}" class="btn">
          <img src="{{ asset($facs['Value'] == 'Umum' ? 'storage/asset/' . Str::replace(' ', '_', $facs['Value']) . '.jpg' : 'storage/asset/Fakultas_' . Str::replace(' ', '_', $facs['Value']) . '.jpg') }}" class="img-preview" style="height:200px; max-width:100%;" role="button" id="myfile" name="myfile">
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
            <div class="text-normal mb-2">Pilih Jurusan: </div>
            @foreach($facs['jurusan'] as $jurusan)
            @if(Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $jurusan))->getSnapshot()->exists())
            <ul>
              <li>
                <a style="text-decoration: none; color: gray;" href="/course/{{ Str::replace(' ','_',$jurusan) }}">
                  {{ $jurusan }} >
                </a>
              </li>
            </ul>
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
      if (modal.children.length <= 0) {
        div.style.display = "none";
      }
    </script>
    @endforeach
  </div>
</div>

@endsection