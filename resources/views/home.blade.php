@extends('layouts.main')

@section('container')
<div class="row">
    <div class="row my-5">
        <div class="col bold" style="color: #101828; font-size: 62px;">
            <p class="ff-inter">Bersiaplah untuk <br> Sukses Akademis</p>
            <div class="row mb-5 ms-1" style="color: #646464; size: 20px; font-size: 1rem; font-weight: normal;">
                Selamat datang di Edukas1, sumber terpercaya <br> untuk belajar mata kuliah secara efektif.
            </div>
            <button style="width: 143px; height: 60px;" class="btn btn-primary mb-5 "><a href="/register" class="nav-link text-light" style="font-size:18px; font-weight: 600;">Start Now</a></button>
        </div>
        <div class="col" style="font-size: 0.75px; position: relative;">
            <div style=" height: 750em; position: relative; width: 800em">
                <div style="width: 504em; height: 504em; left: 205em; top: 179em; position: absolute; background: rgba(131.63, 162.73, 246.86, 0.72); border-radius: 9999em"></div>
                <div style="width: 504em; height: 504em; left: 260em; top: 15em; position: absolute; background: rgba(160.40, 185.94, 255, 0.67); border-radius: 9999em"></div>
                <div style="width: 588em; height: 588em; left: 54em; top: 38em; position: absolute; background: #0243F5; border-radius: 9999em"></div>
                <img style="width: 561em; height: 561em; left: 43em; top: 65em; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); border-radius: 9999em" src="{{ asset('storage/asset/Home_Main.jpeg') }}">
                <div style="width: 588em; height: 588em; left: 0em; top: 52em; position: absolute; border-radius: 9999em; border: 1em black solid"></div>
                <img style="width: 142em; height: 142em; left: 421em; top: 517em; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0em 4em 4em rgba(0, 0, 0, 0.25); border-radius: 9999em" src="{{ asset('storage/asset/Home_Bottom.png') }}">
                <img style="width: 142em; height: 142em; left: 517em; top: 65em; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0em 4em 4em rgba(0, 0, 0, 0.25); border-radius: 9999em" src="{{ asset('storage/asset/Home_Top.png') }}">
                <div style="width: 588em; height: 588em; left: 16em; top: 0em; position: absolute; border-radius: 9999em; border: 1em black solid"></div>
                <img style="width: 142em; height: 142em; left: 550em; top: 306em; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0em 4em 4em rgba(0, 0, 0, 0.25); border-radius: 9999em" src="{{ asset('storage/asset/Home_Middle.png') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="col" style="color: #0038CF; font-size: 16px; text-align:center;">
                <p class="ff-inter" style="font-weight: 600;">About Us</p>
            </div>
        </div>
        <div class="row">
            <div class="col mb-5" style="color: #101828; font-size: 36px; text-align:center; font-weight: 600;">
                <p class="ff-inter">Pengalaman dengan Fleksibilitas Belajar!</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col mx-2 text-end">
                <img src="{{ asset('storage/asset/Home_About.jpeg') }}" alt="" style="width: 524px; height:372px;">
            </div>
            <div class="col mx-2" style="font-size: 30px; margin-top: 100px;">
                <p class="ff-inter" style="font-size: 20px;">Di Edukas1, kami memahami bahwa pendidikan adalah fondasi untuk membangun masa depan yang sukses. Oleh karena itu, kami menawarkan berbagai kursus yang dirancang untuk memberikan pendidikan yang berkualitas dan akses mudah ke sumber daya pendidikan terkini.</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col" style="text-align:center;">
                <button style="width: 143px; height: 60px; text-align:center;" class="btn btn-primary mb-5 ms-3"><a href="/about" class="nav-link text-light" style="font-size:18px; font-weight: 600;">See All</a></button>
            </div>
        </div>
    </div>
    @endsection