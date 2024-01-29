@extends('adPanel.layouts.main')

@section('container')
@php
    $angka = collect();
    foreach(Firebase::database()->getReference('videos/' . $jurusan)->getValue() as $i){
        if(array_key_exists('buy_count', $i)){
            $angka->put($i['Judul_Video'], $i['buy_count']);
        }
    }
    $key = array_keys($angka->sortDesc()->all());
    $value = $angka->sortDesc()->values()->all();
@endphp
<form action="/adPanel" method="post" id="formJurusan">
    @csrf
    <div class="form-floating mb-3">
        <select class="form-select" name="jurusan" id="jurusan" onchange="Jurusan()">
            @foreach(array_keys($videos) as $i)
                @if($jurusan == $i)
                    <option value="{{ $i }}" selected>{{ Str::replace('_', ' ', $i) }}</option>
                @else
                    <option value="{{ $i }}">{{ Str::replace('_', ' ', $i) }}</option>
                @endif
            @endforeach
        </select>
        <label for="tahun">Jurusan</label>
    </div>
</form>

<div class="row mb-4">
    <div class="col mr-4">
        <div class="card">
            <canvas id="chart-what"></canvas>
        </div>
    </div>
    <div class="col mr-4">
        <div class="card">
            <canvas id="chart-when"></canvas>
        </div>
    </div>
    <div class="col mr">
        <div class="card">
            <canvas id="chart-where"></canvas>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <canvas id="chart-penjualan-bruto"></canvas>
        </div>
    </div>
</div>

<h2 style="color: #0038CF; font-weight:700;">Top Sales {{ Str::replace('_', ' ', $jurusan) }}</h2>

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
    /** 
     * UTILS SECTION
     * Can move these utils to a separate script.js for global usage
     */
    class Utils {
        valueOrDefault(value, defaultValue) {
            return value == null ? defaultValue : value
        }

        _seed = Date.now();

        srand(seed) {
            _seed = seed;
        }

        rand(min, max) {
            min = valueOrDefault(min, 0);
            max = valueOrDefault(max, 0);
            _seed = (_seed * 9301 + 49297) % 233280;
            return min + (_seed / 233280) * (max - min);
        }

        numbers(config) {
            var cfg = config || {};
            var min = valueOrDefault(cfg.min, 0);
            var max = valueOrDefault(cfg.max, 100);
            var from = valueOrDefault(cfg.from, []);
            var count = valueOrDefault(cfg.count, 8);
            var decimals = valueOrDefault(cfg.decimals, 8);
            var continuity = valueOrDefault(cfg.continuity, 1);
            var dfactor = Math.pow(10, decimals) || 0;
            var data = [];
            var i, value;

            for (i = 0; i < count; ++i) {
                value = (from[i] || 0) + this.rand(min, max);
                if (this.rand() <= continuity) {
                    data.push(Math.round(dfactor * value) / dfactor);
                } else {
                    data.push(null);
                }
            }

            return data;
        }

        points(config) {
            const xs = this.numbers(config);
            const ys = this.numbers(config);
            return xs.map((x, i) => ({
                x,
                y: ys[i]
            }));
        }

        bubbles(config) {
            return this.points(config).map(pt => {
                pt.r = this.rand(config.rmin, config.rmax);
                return pt;
            });
        }

        labels(config) {
            var cfg = config || {};
            var min = cfg.min || 0;
            var max = cfg.max || 100;
            var count = cfg.count || 8;
            var step = (max - min) / count;
            var decimals = cfg.decimals || 8;
            var dfactor = Math.pow(10, decimals) || 0;
            var prefix = cfg.prefix || '';
            var values = [];
            var i;

            for (i = min; i < max; i += step) {
                values.push(prefix + Math.round(dfactor * i) / dfactor);
            }

            return values;
        }

        MONTHS = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        months(config) {
            var cfg = config || {};
            var count = cfg.count || 12;
            var section = cfg.section;
            var values = [];
            var i, value;

            for (i = 0; i < count; ++i) {
                value = this.MONTHS[Math.ceil(i) % 12];
                values.push(value.substring(0, section));
            }

            return values;
        }

        COLORS = [
            '#4dc9f6',
            '#f67019',
            '#f53794',
            '#537bc4',
            '#acc236',
            '#166a8f',
            '#00a950',
            '#58595b',
            '#8549ba'
        ];

        color(index) {
            return COLORS[index % COLORS.length];
        }

        transparentize(value, opacity) {
            var alpha = opacity === undefined ? 0.5 : 1 - opacity;
            return colorLib(value).alpha(alpha).rgbString();
        }

        CHART_COLORS = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        NAMED_COLORS = [
            this.CHART_COLORS.red,
            this.CHART_COLORS.orange,
            this.CHART_COLORS.yellow,
            this.CHART_COLORS.green,
            this.CHART_COLORS.blue,
            this.CHART_COLORS.purple,
            this.CHART_COLORS.grey,
        ];

        namedColor(index) {
            return NAMED_COLORS[index % NAMED_COLORS.length];
        }

        newDate(days) {
            return DateTime.now().plus({
                days
            }).toJSDate();
        }

        newDateString(days) {
            return DateTime.now().plus({
                days
            }).toISO();
        }

        parseISODate(str) {
            return DateTime.fromISO(str);
        }
    }
    /** End of Utils class */

    function Jurusan() {
        document.getElementById('formJurusan').submit();
    }
    var key = "<?php count($angka) > 0 ? json_encode($key) : 0 ?>";
    var value = "<?php count($angka) > 0 ? json_encode($value) : 0 ?>";

    var chartPenjualanBruto = document.getElementById("chart-penjualan-bruto");
    new Chart(chartPenjualanBruto, {
        type: 'bar',
        data: {
            labels: key,
            datasets: [{
                label: 'Bruto Penjualan Video EdukaS1',
                data: value,
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

    const mock = [0, 20, 20, 60, 60, 120, NaN, 180, 120, 125, 105, 110, 170];;
    const utils = new Utils()
    const data = {
        labels: utils.months({
            count: mock.length
        }),
        datasets: [{
            label: 'Teknik',
            data: mock,
            borderColor: "#0d6efd",
            fill: false,
            cubicInterpolationMode: 'monotone',
            tension: 0.4
        }, {
            label: 'Psikologi',
            data: mock,
            borderColor: "#6610f2",
            fill: false,
            tension: 0.4
        }, {
            label: 'Bisnis',
            data: mock,
            borderColor: "#ccc",
            fill: false
        }]
    };

    var chartWhat = document.getElementById('chart-what')
    new Chart(chartWhat, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Penjualan per fakultas'
                }
            }
        },
    })

    var chartWhen = document.getElementById('chart-when')
    new Chart(chartWhen, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pembelian per fakultas'
                }
            }
        },
    })

    var chartWhere = document.getElementById('chart-where')
    new Chart(chartWhere, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Pen apaan per fakultas'
                }
            }
        },
    })
</script>
@endsection