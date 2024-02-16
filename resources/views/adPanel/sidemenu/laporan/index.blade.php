@extends('adPanel.layouts.main')

@section('container')
@php
    $bulan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $minggu = [0, 0, 0, 0];
    if($month == 1){
        $textMonth = 'Januari';
    } else if($month == 2){
        $textMonth = 'Februari';
    } else if($month == 3){
        $textMonth = 'Maret';
    } else if($month == 4){
        $textMonth = 'April';
    } else if($month == 5){
        $textMonth = 'Mei';
    } else if($month == 6){
        $textMonth = 'Juni';
    } else if($month == 7){
        $textMonth = 'Juli';
    } else if($month == 8){
        $textMonth = 'Agustus';
    } else if($month == 9){
        $textMonth = 'September';
    } else if($month == 10){
        $textMonth = 'Oktober';
    } else if($month == 11){
        $textMonth = 'November';
    } else if($month == 12){
        $textMonth = 'Desember';
    }
@endphp
@foreach($snapshots as $snapshot)
    @if(array_key_exists('validation_date', $snapshot))
        @if(date('Y', strtotime($snapshot['validation_date']))==$year)
            @php
                $bulan[date('m', strtotime($snapshot['validation_date']))-1] += $snapshot['total']
            @endphp
            @if(date('m', strtotime($snapshot['validation_date']))==$month)
                @php
                    if(date('d', strtotime($snapshot['validation_date'])) >= 1 && date('d', strtotime($snapshot['validation_date'])) <= 7){
                        $minggu[0] += $snapshot['total'];
                    }
                    else if(date('d', strtotime($snapshot['validation_date'])) >= 8 && date('d', strtotime($snapshot['validation_date'])) <= 14){
                        $minggu[1] += $snapshot['total'];
                    }
                    else if(date('d', strtotime($snapshot['validation_date'])) >= 15 && date('d', strtotime($snapshot['validation_date'])) <= 21){
                        $minggu[2] += $snapshot['total'];
                    }
                    else if(date('d', strtotime($snapshot['validation_date'])) >= 22 && date('d', strtotime($snapshot['validation_date'])) <= 31){
                        $minggu[3] += $snapshot['total'];
                    }
                @endphp
            @endif
        @endif
    @endif
@endforeach
    <div style="height:400px; width: 900px; margin:auto;">
        <form action="/adPanel/laporan" id="formTahun" method="post">
            @csrf
            <div class="form-floating mb-3">
                <select class="form-select" name="tahun" id="tahun">
                    @for($i = 2000; $i <= date('Y', strtotime(Carbon\Carbon::now())); $i++)
                        @if($i==$year)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
                <label for="tahun">Tahun</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" name="bulan" id="bulan" onchange="Tahun()">
                    <option value="1" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
                    <option value="2" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
                    <option value="3" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
                    <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
                    <option value="5" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
                    <option value="6" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
                    <option value="7" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
                    <option value="8" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
                    <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
                    <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
                    <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                    <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
                </select>
                <label for="bulan">Bulan</label>
            </div>
        </form>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Tahunan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Bulanan</button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="card">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <div class="card">
                    <canvas id="barBulan"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function Tahun(){
            document.getElementById('formTahun').submit();
        }

        var barCanvas = document.getElementById("barChart");
        new Chart(barCanvas,{
            type: 'line',
            data:{
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets:[{
                    label: 'Bruto Penjualan Video EdukaS1 Tahun {{ $year }}',
                    data: ["{{ $bulan[0] }}", "{{ $bulan[1] }}", "{{ $bulan[2] }}", "{{ $bulan[3] }}", "{{ $bulan[4] }}", "{{ $bulan[5] }}", "{{ $bulan[6] }}", "{{ $bulan[7] }}", "{{ $bulan[8] }}", "{{ $bulan[9] }}", "{{ $bulan[10] }}", "{{ $bulan[11] }}",],
                    backgroundColor: "rgba(0,0,255,0.2)",
                    borderColor: "black",
                    borderWidth: 1,
                }]
            },
            options:{
                scales:{
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan Penjualan',
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
                            text: 'Bruto Penjualan Video EdukaS1',
                            color: 'black'
                        },
                        ticks: {
                            color: 'black'
                        }
                    }
                }
            }
        });

        var barBulan = document.getElementById("barBulan");
        new Chart(barBulan,{
            type: 'line',
            data:{
                labels: ['Minggu ke-1', 'Minggu ke-2', 'Minggu ke-3', 'Minggu ke-4'],
                datasets:[{
                    label: 'Bruto Penjualan Video EdukaS1 {{ $textMonth }}',
                    data: ["{{ $minggu[0] }}", "{{ $minggu[1] }}", "{{ $minggu[2] }}", "{{ $minggu[3] }}"],
                    backgroundColor: "rgba(0,0,255,0.2)",
                    borderColor: "black",
                    borderWidth: 1,
                }]
            },
            options:{
                scales:{
                    x: {
                        title: {
                            display: true,
                            text: 'Minggu Penjualan',
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
                            text: 'Bruto Penjualan Video EdukaS1',
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