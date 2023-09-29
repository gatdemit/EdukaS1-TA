@extends('layouts.main')

@section('container')
        <div class='container-fluid'>
            @yield('container-header')
            <div class="row">
                <main class="col-md-9 col-lg-10">
                    @yield('container-top')
                    <div class="d-flex align-items-center border bg-body-tertiary">
                        @yield('container-main')
                    </div>
                </main>
            </div>
        </div>
@endsection