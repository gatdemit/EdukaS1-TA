@extends('layouts.main')

@section('container')
<style>
    .fadedfx {
        background-color: #fe5652;
        visibility: hidden;
    }

    .fadeIn {
        animation-name: fadeIn;
        -webkit-animation-name: fadeIn;
        animation-duration: 1.5s;
        -webkit-animation-duration: 1.5s;
        animation-timing-function: ease-in-out;
        -webkit-animation-timing-function: ease-in-out;
        visibility: visible !important;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0.0;
        }
        100% {
        o   pacity: 1;
        }
    }

@-webkit-keyframes fadeIn {
    0% {
            opacity: 0.0;
        }
        100% {
            opacity: 1;
        }
    }

</style>
<div class="container  m-auto row">
    <div class="col-3">
        @include('dashboard.layouts.sidebar3')
    </div>
    <div class="col-9 p-3 border border-1 shadow shadow-md rounded">
        <div class="table-responsive">
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
            <div class="container">
                <p style="display:none;">{{ $total = 0; }}</p>
                @if(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue() != null) 
                    @if(!Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['checkout'])
                        @foreach(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['Keranjang'] as $snapshot)
                        <p style="display:none;">{{ $total += $snapshot['Harga']; }}</p>
                            <div class="row border border-1 mb-4 rounded shadow shadow-md p-3">
                                <div class="col-9 p-3">
                                    <h4 class="ff-raleway" style="color: #0038CF; font-weight: 800;">{{ Str::title($snapshot['Judul Video']) }}</h4>
                                    <h6 class="ff-raleway fw-bold">Fakultas: {{ Str::title($snapshot['Fakultas']) }}</h6>
                                    <h6 class="ff-raleway fw-bold">Jurusan: {{ Str::title($snapshot['Jurusan']) }}</h6>
                                    <h6 class="ff-raleway fw-bold">Harga: Rp {{ $snapshot['Harga'] }}</h6>
                                    <form action="/remove" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                        <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                        <button class="btn btn-outline-danger" style="font-weight: 500; font-family: Raleway">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @else
                    <div class="col-9 p-3">
                        Cart is Empty
                    </div>
                @endif
                <div class="d-flex justify-content-between p-3 text-end border border-1 rounded shadow shadow-md mb-3">
                    <h4 style="font-family: Raleway;">Subtotal</h4>
                    <div>
                        <p style="font-family: Raleway;">Rp {{ $total }}</p>
                        <form action="/checkout" method="POST">
                            @csrf
                            <input type="hidden" id="email" name="email" value="{{ Session::get('email') }}">
                            <button class="btn btn-primary" style="font-family: Raleway; font-weight: 500;">
                                Check Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection