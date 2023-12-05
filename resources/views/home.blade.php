@extends('layouts.main')

@section('container')
    <div class="row" style="margin-bottom: 200px;">
        <div class="row my-5">
            <div class="col bold" style="color: #101828; font-size: 62px;">
                <p class="ff-inter">Bersiaplah untuk Sukses <br> Akademis</p>
            </div>
            <div class="col-7">
                <div style="width: 100%; height: 100%; position: relative">
                    <div style="width: 504px; height: 504px; left: 205px; top: 179px; position: absolute; background: rgba(131.63, 162.73, 246.86, 0.72); border-radius: 9999px"></div>
                    <div style="width: 504px; height: 504px; left: 260px; top: 15px; position: absolute; background: rgba(160.40, 185.94, 255, 0.67); border-radius: 9999px"></div>
                    <div style="width: 588px; height: 588px; left: 54px; top: 38px; position: absolute; background: #0243F5; border-radius: 9999px"></div>
                    <img style="width: 561px; height: 561px; left: 43px; top: 65px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); border-radius: 9999px" src="{{ asset('storage/asset/Home_Main.jpeg') }}">
                    <div style="width: 588px; height: 588px; left: 0px; top: 52px; position: absolute; border-radius: 9999px; border: 1px black solid"></div>
                    <img style="width: 142px; height: 142px; left: 421px; top: 517px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 9999px" src="{{ asset('storage/asset/Home_Bottom.png') }}">
                    <img style="width: 142px; height: 142px; left: 517px; top: 65px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 9999px" src="{{ asset('storage/asset/Home_Top.png') }}">
                    <div style="width: 588px; height: 588px; left: 16px; top: 0px; position: absolute; border-radius: 9999px; border: 1px black solid"></div>
                    <img style="width: 142px; height: 142px; left: 550px; top: 306px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 9999px" src="{{ asset('storage/asset/Home_Middle.png') }}">
                </div>
            </div>
        </div>
        <div class="row mb-5 ms-1" style="color: #646464; size: 20px;">
            Selamat datang di Edukas1, sumber terpercaya <br> untuk belajar mata kuliah secara efektif.
        </div>
        <button style="width: 143px; height: 60px;"class="btn btn-primary mb-5 ms-3"><a href="/register" class="nav-link text-light" style="font-size:18px; font-family: Inter; font-weight: 600;">Start Now</a></button>
    </div>
    <div class="row" style="margin-top: 500px;">
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
                <button style="width: 77px; height: 40px; text-align:center;"class="btn btn-primary mb-5 ms-3"><a href="/about" class="nav-link text-light" style="font-size:14px; font-weight: 600;">See All</a></button>
            </div>
        </div>
    </div>
@endsection