@extends('adPanel.layouts.main')

@section('container')
@php
    $bulan = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
@endphp
@foreach($snapshots as $snapshot)
    @if(array_key_exists('validation_date', $snapshot))
        @if(date('Y', strtotime($snapshot['validation_date']))==$tahun)
            @php
                $bulan[date('m', strtotime($snapshot['validation_date']))-1] += $snapshot['total']
            @endphp
        @endif
    @endif
@endforeach
    <div style="height:400px; width: 900px; margin:auto;">
        <h1 style="color: #0038CF;; font-weight: 700;">Laporan Pendapatan Bruto EdukaS1</h1>
        <form action="/adPanel/laporan" id="formTahun" method="post">
            @csrf
            <div class="form-floating mb-3">
                <select class="form-select" name="tahun" id="tahun" onchange="Tahun()">
                    @for($i = 2000; $i<=date('Y', strtotime(Carbon\Carbon::now())); $i++)
                        @if($i==$tahun)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
                <label for="tahun">Tahun</label>
            </div>
        </form>
        <canvas id="barChart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function Tahun(){
            document.getElementById('formTahun').submit();
        }
        var data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        var barCanvas = document.getElementById("barChart");
        new Chart(barCanvas,{
            type: 'bar',
            data:{
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets:[{
                    label: 'Bruto Penjualan Video EdukaS1',
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
                            text: 'Bulan Penjualan'
                        }
                    }, 
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Bruto Penjualan Video EdukaS1'
                        }
                    }
                }
            }
        });
    </script>
@endsection