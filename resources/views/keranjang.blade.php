@extends('layouts.main')

@section('container')

    <div class="table-responsive col-lg-8">
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
        <table class="table table-striped table-sm">
            <p style="display:none;">{{ $total = 0; }}</p>
            <thead>
                <tr>
                    <th>Judul Video</th>
                    <th>Fakultas</th>
                    <th>Jurusan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @if(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue() != null)    
                    @if(!Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['checkout'])
                        @foreach(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['Keranjang'] as $snapshot)
                        <p style="display:none;">{{ $total += $snapshot['Harga']; }}</p>
                            <tr>
                                <td>{{ $snapshot['Judul Video'] }}</td>
                                <td>{{ $snapshot['Fakultas'] }}</td>
                                <td>{{ $snapshot['Jurusan'] }}</td>
                                <td>{{ $snapshot['Harga'] }}</td>
                                <form action="/remove" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" id="email" value="{{ Session::get('email') }}">
                                    <input type="hidden" name="video" id="video" value="{{ $snapshot['Video'] }}">
                                    <td>
                                        <button class="btn btn-danger">remove</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>Keranjang Kosong</td>
                    </tr>
                    @endif
                @else
                <tr>
                    <td>Keranjang Kosong</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td>Total</td>
                    <td>{{ $total }}</td>
                </tr>
            </tfoot>
        </table>
        <form action="/checkout" method="POST">
            @csrf
            <input type="hidden" id="email" name="email" value="{{ Session::get('email') }}">
            <button class="btn btn-success">Checkout</button>
        </form>
        <form action="/removeAll" method="POST">
            @csrf
            <input type="hidden" id="email" name="email" value="{{ Session::get('email') }}">
            <button class="btn btn-danger">Batalkan</button>
        </form>
    </div>
@endsection