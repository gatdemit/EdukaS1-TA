<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    {{-- Booststrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- My CSS --}}
    <link href="/css/style.css" rel="stylesheet">
    
    <title>{{ $title }}</title>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <header class="row mx-5 mt-2">
        @include('layouts.header')
    </header>

    <main class="row mx-5 pb-5">
        <div>
            @yield('container')
        </div>
    </main>
    
    <footer class="row mt-5 pt-5">
        @include('layouts.footer')
    </footer>
</body>
</html>