@extends('adPanel.layouts.main')

@section('container-header')
    <h1>Transaksi</h1>
@endsection

@section('container')
    <div class="table-responsive col-lg-8">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Tagihan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @if($snapshots != null)
                    @foreach($snapshots as $snapshot)
                        @if($snapshot['checkout'] && !array_key_exists('validation_date', $snapshot))
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
                                        <input type="hidden" name="total" id="total" value="{{ $tagihan }}">
                                        <button class="btn btn-primary">Validate</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr><td>Transaksi Doesn't Exist yet</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <script>
        var tBody = document.getElementById('tbody');
        var errorCode = "<tr><td>Transaksi Doesn't Exist yet</td></tr>";
        console.log(tBody.childNodes.length)
        if(tBody.childNodes.length<=1){
            console.log(false);
            tbody.innerHTML= errorCode;
        }
    </script>
@endsection