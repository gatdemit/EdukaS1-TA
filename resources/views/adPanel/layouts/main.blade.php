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

    <div class="position-absolute top-0 end-0">
        <nav class="navbar navbar expand-lg bg-body tertiary">
            <div class="container-fluid">
                <div class="collaps navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class ="btn btn-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mt-4">
        <div class="container-fluid">
            @yield('container-header')
            <div class="row">
                @include('adPanel.layouts.sidebar')
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('container')
                </main>
            </div>
        </div>
    </div>

    
    
    
</body>
</html>