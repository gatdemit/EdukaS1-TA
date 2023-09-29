@extends('layouts.main')

<h1>ini course</h1>

<div class="container">
  <div class="row">
    @for($i=0; $i< count($facs); $i++)
      <div class="col-md-3 mb-4">
        <div class="card">
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#{{ Str::replace(' ','',array_keys($facs)[$i]) }}">
            <img src="{{ asset('storage/asset/'. array_keys($facs)[$i].'.jpg') }}" class="img-preview" style="height:130px; width:200px; max-height:130px; max-width:200px;" role="button" id="myfile" name="myfile">
            <div role="button" class="caption" id="other" name="other">
              <p style="margin-top:-57.5px;">{{ array_keys($facs)[$i] }}</p>
            </div>
          </button>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="{{ Str::replace(' ','',array_keys($facs)[$i]) }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">{{ array_keys($facs)[$i] }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              @for($k=0; $k < count($facs[array_keys($facs)[$i]]); $k++)
                <a href="/course/{{ Str::replace(' ','_',$facs[array_keys($facs)[$i]][$k]) }}">
                  <p>
                    {{ $facs[array_keys($facs)[$i]][$k] }}
                  </p>
                </a>
              @endfor
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      <!--End Modal-->
    @endfor
  </div>
</div>