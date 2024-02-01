@extends('adPanel.layouts.main')

@section('container')
@php
    $vidCount = 0;
    $angka = collect();
    $rating = collect();
    $tampil = collect();
    $tampil_rate = collect();
    foreach(Firebase::database()->getReference('videos')->getValue() as $j){
        $vidCount += count($j);
        foreach($j as $i){
            if(array_key_exists('buy_count', $i)){
                $angka->put($i['Judul_Video'], [
                    'Judul' => $i['Judul_Video'],
                    'buy_count' => $i['buy_count'],
                    'Fakultas' => $i['Fakultas'],
                    'Jurusan' => $i['Jurusan']
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
    $key = array_keys(array_keys($tampil->sortDesc()->all()));
    $value = $tampil->sortDesc()->all();
    $key_rate = array_keys($tampil_rate->sortDesc()->all());
    $value_rate = $tampil_rate->sortDesc()->all();
    $mostBought = array_keys($value)[0];
    $mostRated = array_keys($value_rate)[0];

@endphp

<div class="row mb-3">
    <div class="col">
        <div class="card" style="text-align: center;">
            <div class="card-body">
                <h4 style="color: #0038CF; font-weight:700;">Jumlah video yang telah diunggah:</h4>
                <div class="bold" style="font-size: 24px;">{{ $vidCount }}</div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="text-align: center;">
            <div class="card-body">
                <h4 style="color: #0038CF; font-weight:700;">Video paling banyak dibeli:</h4>
                <div class="bold">{{ $mostBought }}</div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card" style="text-align: center;">
            <div class="card-body">
                <h4 style="color: #0038CF; font-weight:700;">Video dengan rating tertinggi:</h4>
                <div class="bold">{{ $mostRated }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <canvas id="chartMostBought"></canvas>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <canvas id="chartMostRated"></canvas>
        </div>
    </div>
</div>


<div class="table-responsive small row">
    <div class="col">
        <h2 style="color: #0038CF; font-weight:700;">Video Top Selling EdukaS1</h2>
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
                    @for($index = 0; $index < count($angka->all()); $index++)
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
    <div class="col">
        <h2 style="color: #0038CF; font-weight:700;">Video Top Rated EdukaS1</h2>
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
                    @for($index = 0; $index < count($rating->all()); $index++)
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var key = {!! json_encode($key) !!};
    var value = {!! json_encode($value) !!};

    console.log(key);

    var chartPenjualanBruto = document.getElementById("chartMostBought");
    new Chart(chartPenjualanBruto, {
        type: 'bar',
        data: {
            labels: key,
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
                        text: 'Judul Video'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Penjualan'
                    }
                }
            }
        }
    });

    var key_rate = {!! json_encode($key_rate) !!};
    var value_rate = {!! json_encode($value_rate) !!};

    var chartMostRated = document.getElementById("chartMostRated");
    new Chart(chartMostRated, {
        type: 'bar',
        data: {
            labels: key_rate,
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
                        text: 'Judul Video'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Penjualan'
                    }
                }
            }
        }
    });
</script>
@endsection