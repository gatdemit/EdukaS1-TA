@extends('dosPanel.layouts.main')

@section('container')
@php
    $vidCount = 0;
    $angka = collect();
    $rating = collect();
    $tampil = collect();
    $tampil_rate = collect();
    
    foreach(Firebase::database()->getReference('dosen/' . Session::get('email') .'/vids/')->getValue() as $j){
        $vidCount += count($j);
        foreach($j as $k){
            $i = Firebase::database()->getReference('videos/' . Str::replace(' ', '_', $k['Jurusan']) . '/' . $k['Video'])->getValue();
            if(array_key_exists('buy_count', $i)){
                $angka->put($i['Judul_Video'], [
                    'Judul' => $i['Judul_Video'],
                    'buy_count' => $i['buy_count'],
                    'Fakultas' => $i['Fakultas'],
                    'Jurusan' => $i['Jurusan'],
                ]);
            }
            if(array_key_exists('rating', $i)){
                $rating->put($i['Judul_Video'], [
                    'Judul' => $i['Judul_Video'],
                    'rate_count' => $i['rate_count'],
                    'rate_sum' => $i['rating'],
                    'rating' => $i['rating']/$i['rate_count'],
                    'Fakultas' => $i['Fakultas'],
                    'Jurusan' => $i['Jurusan']
                ]);
            }
        }
    }
    foreach($angka->all() as $count){
        $tampil->put($count['Judul'], $count['buy_count']);
    }
    foreach($rating->all() as $count){
        $tampil_rate->put($count['Judul'], $count['rating']);
    }
    $value = $tampil->sortDesc()->all();
    $values = $tampil->sortDesc()->values()->all();
    $value_rate = $tampil_rate->sortDesc()->all();
    $values_rate = $tampil_rate->sortDesc()->values()->all();
    $mostBought = $value != null ? array_keys($value)[0] : '-';
    $mostRated = $value_rate != null ? array_keys($value_rate)[0] : '-';
@endphp

<div class="row mb-3">
    <div class="col">
        <div class="card h-100" style="text-align: center;">
            <div class="card-body">
                <h4 style="color: #0038CF; font-weight:700;">Jumlah video yang telah diunggah:</h4>
                <div class="bold" style="font-size: 24px;">{{ $vidCount }}</div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100" style="text-align: center;">
            <div class="card-body">
                <h4 style="color: #0038CF; font-weight:700;">Video paling banyak dibeli:</h4>
                <div class="bold">{{ $mostBought }}</div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100" style="text-align: center;">
            <div class="card-body">
                <h4 style="color: #0038CF; font-weight:700;">Video dengan rating tertinggi:</h4>
                <div class="bold">{{ $mostRated }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Top Selling</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Top Rated</button>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="col mt-3">
            <div class="card">
                <canvas id="chartMostBought"></canvas>
            </div>
        </div>
        <div class="table-responsive small row mt-3">
            <div class="col">
                <h2 style="color: #0038CF; font-weight:700;">Video Top Selling Anda</h2>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Jumlah Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                            @for($index = 0; $index < 10 && $index < count($angka->all()); $index++)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $angka->all()[array_keys($value)[$index]]['Judul'] }}</td>
                                    <td>{{ $angka->all()[array_keys($value)[$index]]['Fakultas'] }}</td>
                                    <td>{{ $angka->all()[array_keys($value)[$index]]['Jurusan'] }}</td>
                                    <td>{{ $angka->all()[array_keys($value)[$index]]['buy_count'] }}</td>
                                </tr>
                            @endfor  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
    <div class="col mt-3">
        <div class="card">
            <canvas id="chartMostRated"></canvas>
        </div>
    </div>
    <div class="table-responsive small row mt-3">
        <div class="col">
            <h2 style="color: #0038CF; font-weight:700;">Video Top Rated Anda</h2>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Fakultas</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                        @for($index = 0; $index < 10 && $index < count($rating->all()); $index++)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $rating->all()[array_keys($value_rate)[$index]]['Judul'] }}</td>
                                <td>{{ $rating->all()[array_keys($value_rate)[$index]]['Fakultas'] }}</td>
                                <td>{{ $rating->all()[array_keys($value_rate)[$index]]['Jurusan'] }}</td>
                                <td>{{ $rating->all()[array_keys($value_rate)[$index]]['rating'] }}</td>
                            </tr>
                        @endfor  
                </tbody>
            </table>
        </div>
    </div>
  </div>
  <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab" tabindex="0">...</div>
  <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">...</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var value = {!! json_encode($values) !!};

    var chartPenjualanBruto = document.getElementById("chartMostBought");
    new Chart(chartPenjualanBruto, {
        type: 'bar',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            datasets: [{
                label: 'Top Selling Video EdukaS1',
                data: value,
                backgroundColor: "rgba(0,0,255,0.2)",
                borderColor: "black",
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nomor Entri pada Tabel',
                        color: 'black'
                    },
                    ticks: {
                        color: 'black'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Penjualan',
                        color: 'black'
                    },
                    ticks: {
                        color: 'black'
                    }
                }
            }
        }
    });

    var value_rate = {!! json_encode($values_rate) !!};

    var chartMostRated = document.getElementById("chartMostRated");
    new Chart(chartMostRated, {
        type: 'bar',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            datasets: [{
                label: 'Top Rated Video EdukaS1',
                data: value_rate,
                backgroundColor: "rgba(0,0,255,0.2)",
                borderColor: "black",
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Nomor Entri pada Tabel',
                        color: 'black'
                    },
                    ticks: {
                        color: 'black'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Penjualan',
                        color: 'black'
                    },
                    ticks: {
                        color: 'black'
                    }
                }
            }
        }
    });
</script>
@endsection