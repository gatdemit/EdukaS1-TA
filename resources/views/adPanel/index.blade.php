@extends('adPanel.layouts.main')

@section('container')
@php
    $angka = collect();
    foreach(Firebase::database()->getReference('videos/' . $jurusan)->getValue() as $i){
        $angka->put($i['Judul_Video'], $i['buy_count']);
    }
    $key = array_keys($angka->sortDesc()->all());
    $value = $angka->sortDesc()->values()->all();
@endphp
    <form action="/adPanel" method="post" id="formJurusan">
        @csrf
        <div class="form-floating mb-3">
            <select class="form-select" name="jurusan" id="jurusan" onchange="Jurusan()">
                @foreach(array_keys($videos) as $i)
                    <option value="{{ $i }}">{{ Str::replace('_', ' ', $i) }}</option>
                @endforeach
            </select>
            <label for="tahun">Jurusan</label>
        </div>
    </form>
    <canvas id="chart"></canvas>
    <h2>Section title</h2>
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Judul</th>
                <th scope="col">Jumlah Penjualan</th>
              </tr>
            </thead>
            <tbody>
                @foreach(Firebase::database()->getReference('videos/' . $jurusan)->getValue() as $data)
                    <tr>
                        <td>{{ $data['Judul_Video'] }}</td>
                        <td>{{ array_key_exists('buy_count', $data) ? $data['buy_count'] : 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function Jurusan(){
            document.getElementById('formJurusan').submit();
        }
        var key = {!! json_encode($key) !!};
        var value = {!! json_encode($value) !!};
        console.log('{{ $value[0] }}');
        key.forEach((variabel)=>{
            console.log(variabel);
        });
        
        var barCanvas = document.getElementById("chart");
        new Chart(barCanvas,{
            type: 'bar',
            data:{
                labels: key,
                datasets:[{
                    label: 'Bruto Penjualan Video EdukaS1',
                    data: value,
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