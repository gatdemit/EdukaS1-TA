@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Transaksi</h1>
@endsection

@section('container')
    <div class="table-responsive col-lg-8">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Tagihan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($snapshots != null)
                @foreach($snapshots as $snapshot)
                    <tr>
                        <p style="display:none;">{{ $tagihan = 0 }}</p>
                        <td>{{ $snapshot['email'] }}</td>
                        @foreach($snapshot['Keranjang'] as $item)
                        <p style="display:none;">{{ $tagihan += $item['Harga'] }}</p>
                        @endforeach
                        <td>{{ $tagihan }}</td>
                        <td>
                            <form action="/adPanel/transaksi/validate" method="post">
                                @csrf
                                <input type="hidden" name="email" id="email" value="{{ Str::replace('.com','com', $snapshot['email']) }}">
                                <button class="btn btn-primary">Validate</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @else
                    <tr><td>Transaksi Doesn't exist</td></tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection