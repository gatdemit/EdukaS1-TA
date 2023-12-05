<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    {{-- Booststrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Raleway:wght@400;500;700;800&display=swap&family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">

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

    <div class="container" style="margin-top: 100px;">
        <div class="container-fluid">
            <div class="row">
                @include('adPanel.layouts.sidebar')
                <main class="col-md-8 ms-sm-auto col-lg-9 px-md-4">
                    @yield('container')
                </main>
            </div>
        </div>
    </div>

    
    @include('layouts.footer')
    
</body>
</html>