@extends('adPanel.layouts.main')

@section('container')
    <div class="table-responsive border border-1 rounded shadow shadow-md p-5">
        <h1 style="font-weight: 700; color: #0038CF;">Transaksi</h1>
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
        <div class="d-flex justify-content-between">
            <div class="form-check form-switch">
                <input type="radio" class="btn-check" name="options" id="option1" value="0" onchange="unvalidated()" checked>
                <label class="btn btn-primary" for="option1" style="font-size: 12px; font-weight: 600;">Unvalidated</label>
                <input type="radio" class="btn-check" name="options" id="option2" value="1" onchange="validated()">
                <label class="btn btn-primary" for="option2" style="font-size: 12px; font-weight: 600;">Validated</label>
            </div>
            <form class="row" action="/adPanel/transaksi" method="post">
                @csrf
                <div class="input-group mb-3 w-50 ms-auto">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input name="search" id="search" type="text" class="form-control" placeholder="Cari Transaksi disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}">
                    <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
                </div>
                <a class="mb-3" href="/adPanel/transaksi" style="text-align: right;">Clear Search</a>
            </form>
        </div>
        <table class="table table-striped table-sm table-hover" id="table">
            <thead>
                <tr style="text-align: center;">
                    <th scope="col">Email</th>
                    <th scope="col">Tagihan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @if($snapshots != null)
                    @if($search)
                        @foreach($snapshots as $snapshot)
                            @if($snapshot['checkout'] && !array_key_exists('validation_date', $snapshot))
                                @if(Str::contains($snapshot['email'], $query))
                                    <tr style="text-align: center;">
                                        <p style="display:none;">{{ $tagihan = 0 }}</p>
                                        <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                        @foreach($snapshot['Keranjang'] as $item)
                                        <p style="display:none;">{{ $tagihan += $item['Harga'] }}</p>
                                        @endforeach
                                        <td style="font-weight: 500;">Rp {{ $tagihan }}</td>
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
                            @endif
                        @endforeach
                    @else
                        @foreach($snapshots as $snapshot)
                            @if($snapshot['checkout'] && !array_key_exists('validation_date', $snapshot))
                                <tr style="text-align: center;">
                                    <p style="display:none;">{{ $tagihan = 0 }}</p>
                                    <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                    @foreach($snapshot['Keranjang'] as $item)
                                    <p style="display:none;">{{ $tagihan += $item['Harga'] }}</p>
                                    @endforeach
                                    <td style="font-weight: 500;">Rp {{ $tagihan }}</td>
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
                    @endif
                @else
                    <tr><td>Transaksi Doesn't Exist yet</td></tr>
                @endif
            </tbody>
        </table>
        <table class="table table-striped table-sm table-hover" id="vtable" style="display: none;">
            <thead>
                <tr style="text-align: center">
                    <th scope="col">Email</th>
                    <th scope="col">Total</th>
                    <th scope="col">Validated On</th>
                </tr>
            </thead>
            <tbody id="vtbody">
                @if($validateds != null)
                    @if($search)
                        @foreach($validateds as $snapshot)
                            @if(Str::contains($snapshot['email'], $query) || Str::contains($snapshot['total'], $query) || Str::contains(Carbon\Carbon::parse($snapshot['validation_date'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l jS F Y'), $query))
                                <tr style="text-align: center;">
                                    <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                    <td style="font-weight: 500;">Rp {{ $snapshot['total'] }}</td>
                                    <td style="font-weight: 500;">{{ Carbon\Carbon::parse($snapshot['validation_date'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l jS F Y') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        @foreach($validateds as $snapshot)
                            <tr style="text-align: center;">
                                <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                <td style="font-weight: 500;">Rp {{ $snapshot['total'] }}</td>
                                <td style="font-weight: 500;">{{ Carbon\Carbon::parse($snapshot['validation_date'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l jS F Y') }}</td>
                            </tr>
                        @endforeach
                    @endif
                @else
                    <tr><td>Transaksi Doesn't Exist yet</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <script>
        var tBody = document.getElementById('tbody');
        var vtBody = document.getElementById('vtbody');
        var table = document.getElementById('table');
        var vtable = document.getElementById('vtable');

        var errorCode = "<tr><td>Transaksi Doesn't Exist yet</td></tr>";
        if(tBody.childNodes.length<=1){
            tbody.innerHTML= errorCode;
        }
        if(vtBody.childNodes.length<=1){
            vtbody.innerHTML= errorCode;
        }

        function validated(){
            vtable.style.display = '';
            table.style.display = 'none';
        }
        function unvalidated(){
            vtable.style.display = 'none';
            table.style.display = '';
        }
    </script>
@endsection