@extends('adPanel.layouts.main')

@section('container')
    <h1 class="bold" style="color: #0038CF;">Welcome to the Admin Panel</h1>
    <div class="row">
        <a href="/adPanel/quiz" class="nav-link col-4 m-2 text-center border border-1 rounded shadow shadow-md"  style="width: 300px;">
            <i class="bi bi-filter-square" style="font-size: 100px;"></i>
            <h3 style="font-weight: 600;">Quiz</h3>
        </a>
        <a href="/adPanel/video" class="nav-link col-4 m-2 text-center border border-1 rounded shadow shadow-md"  style="width: 300px;">
            <i class="bi bi-camera-video" style="font-size: 100px;"></i>
            <h3 style="font-weight: 600;">Video</h3>
        </a>
        <a href="/adPanel/transaksi" class="nav-link col-4 m-2 text-center border border-1 rounded shadow shadow-md" style="width: 300px; height: 300px;">
            <i class="bi bi-currency-dollar" style="font-size: 100px;"></i>
            <h3 style="font-weight: 600;">Transaction</h3>
        </a>
        <a href="/adPanel/users" class="nav-link col-4 m-2 text-center border border-1 rounded shadow shadow-md" style="width: 300px; height: 300px;">
            <i class="bi bi-person-check" style="font-size: 100px;"></i>
            <h3 style="font-weight: 600;">Users</h3>
        </a>
    </div>
@endsection