<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    {{-- Booststrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Raleway:wght@400;500;700;800&display=swap&family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">
    {{-- end fonts --}}

    {{-- My CSS --}}
    <link href="/css/style.css" rel="stylesheet">

    <style>
        * {
            font-family: Inter;
        }

        table * {
            font-family: Montserrat;
        }

        .ff-raleway {
            font-family: Raleway;
            font-weight: bold;
        }
        
        .active {
            color: #fff; /* Warna teks */
            background-color: #007bff; /* Warna latar belakang */
            border-color: #007bff; /* Warna border */
            padding: 0; /* Padding sesuai dengan spesifikasi Bootstrap */
            border-radius: 0.25rem; /* Radius border sesuai dengan spesifikasi Bootstrap */
            cursor: pointer;
        }

    </style>
    
    <title>{{ $title }}</title>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <header class="row px-5 mt-2">
        @include('layouts.header')
    </header>

    <main class="row px-5 pb-5">
        <div>
            @yield('container')
        </div>
    </main>
    
    <footer class="row mt-5 pt-5">
        @include('layouts.footer')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>