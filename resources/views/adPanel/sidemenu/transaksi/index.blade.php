@extends('adPanel.layouts.main')

@section('container')
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
        <div class="d-flex justify-content-end">
            <form class="row" action="/adPanel/transaksi" method="post">
                @csrf
                <div class="input-group mb-3 w-50 ms-auto">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input name="search" id="search" type="text" class="form-control" placeholder="Cari Transaksi disini" aria-label="Username" aria-describedby="basic-addon1" value="{{ $search ? $query : '' }}" required>
                    <button class="btn btn-primary" style="font-weight: 600;">Cari</button>
                </div>
                <a class="mb-3" href="/adPanel/transaksi" style="text-align: right;">Clear Search</a>
            </form>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#unvalidated" type="button" role="tab" aria-controls="unvalidated" aria-selected="true">Belum divalidasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="validated-tab" data-bs-toggle="tab" data-bs-target="#validated" type="button" role="tab" aria-controls="validated" aria-selected="false">Telah divalidasi</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="unvalidated" role="tabpanel" aria-labelledby="unvalidated-tab" tabindex="0">
                    <table class="table table-striped table-sm table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Tagihan</th>
                                <th scope="col" style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @if($snapshots != null)
                                @if($search)
                                    @foreach($snapshots as $snapshot)
                                        @if($snapshot['checkout'] && !array_key_exists('validation_date', $snapshot))
                                            @if(Str::contains(Str::upper($snapshot['email']), Str::upper($query)))
                                                <tr>
                                                    <p style="display:none;">{{ $tagihan = 0 }}</p>
                                                    <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                                    @foreach($snapshot['Keranjang'] as $item)
                                                    <p style="display:none;">{{ $tagihan += $item['Harga'] }}</p>
                                                    @endforeach
                                                    <td style="font-weight: 500;">Rp {{ $tagihan }}</td>
                                                    <td style="text-align: center;">
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
                                            <tr>
                                                <p style="display:none;">{{ $tagihan = 0 }}</p>
                                                <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                                @foreach($snapshot['Keranjang'] as $item)
                                                <p style="display:none;">{{ $tagihan += $item['Harga'] }}</p>
                                                @endforeach
                                                <td style="font-weight: 500;">Rp {{ $tagihan }}</td>
                                                <td style="text-align: center;">
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
            </div>
            <div class="tab-pane" id="validated" role="tabpanel" aria-labelledby="validated-tab" tabindex="0">
                    <table class="table table-striped table-sm table-hover" id="vtable">
                        <thead>
                            <tr>
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
                                            <tr>
                                                <td style="font-weight: 500;">{{ $snapshot['email'] }}</td>
                                                <td style="font-weight: 500;">Rp {{ $snapshot['total'] }}</td>
                                                <td style="font-weight: 500;">{{ Carbon\Carbon::parse($snapshot['validation_date'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l jS F Y') }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    @foreach($validateds as $snapshot)
                                        <tr>
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