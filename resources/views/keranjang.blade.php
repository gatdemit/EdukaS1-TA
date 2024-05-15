@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-4">
    <div class="card-body">
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
                @if(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getSnapshot()->exists()) 
                    @if(!Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['checkout'])
                        @foreach(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['Keranjang'] as $snapshot)
                        <p style="display:none;">{{ $total += $snapshot['Harga']; }}</p>
                            <div class="row border border-1 mb-4 rounded shadow shadow-md p-3">
                                <div class="col-9 p-3">
                                    <h4  style="color: #0038CF; font-weight: 800;">{{ Str::title($snapshot['Judul Video']) }}</h4>
                                    <h6 class="fw-bold">Fakultas: {{ Str::title($snapshot['Fakultas']) }}</h6>
                                    <h6 class="fw-bold">Jurusan: {{ Str::title($snapshot['Jurusan']) }}</h6>
                                    <h6 class="fw-bold">Harga: Rp {{ $snapshot['Harga'] }}</h6>
                                    <form action="/remove" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                        <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                        <button class="btn btn-outline-danger" style="font-weight: 500;">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @else
                    <div class="col-9 p-3">
                        Keranjang Kosong
                    </div>
                @endif
                <div class="d-flex justify-content-between p-3 text-end border border-1 rounded shadow shadow-md mb-3">
                    <h4>Subtotal</h4>
                    <div>
                        <p>Rp {{ $total }}</p>
                        <form action="/checkout" method="POST">
                            @csrf
                            <input type="hidden" id="email" name="email" value="{{ Session::get('email') }}">
                            <button class="btn btn-primary" style="font-weight: 500;">
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