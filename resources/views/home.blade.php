@extends('layouts.main')

@section('container')
    <div class="row" style="margin-bottom: 200px;">
        <div class="row my-5">
            <div class="col bold" style="color: #101828; font-size: 62px;">
                Bersiaplah untuk Sukses <br> Akademis
            </div>
            <div class="col-7">
                <div style="width: 100%; height: 100%; position: relative">
                    <div style="width: 504px; height: 504px; left: 205px; top: 179px; position: absolute; background: rgba(131.63, 162.73, 246.86, 0.72); border-radius: 9999px"></div>
                    <div style="width: 504px; height: 504px; left: 260px; top: 15px; position: absolute; background: rgba(160.40, 185.94, 255, 0.67); border-radius: 9999px"></div>
                    <div style="width: 588px; height: 588px; left: 54px; top: 38px; position: absolute; background: #0243F5; border-radius: 9999px"></div>
                    <img style="width: 561px; height: 561px; left: 43px; top: 65px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); border-radius: 9999px" src="https://via.placeholder.com/561x561">
                    <div style="width: 588px; height: 588px; left: 0px; top: 52px; position: absolute; border-radius: 9999px; border: 1px black solid"></div>
                    <img style="width: 142px; height: 142px; left: 421px; top: 517px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 9999px" src="https://via.placeholder.com/142x142">
                    <img style="width: 142px; height: 142px; left: 517px; top: 65px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 9999px" src="https://via.placeholder.com/142x142">
                    <div style="width: 588px; height: 588px; left: 16px; top: 0px; position: absolute; border-radius: 9999px; border: 1px black solid"></div>
                    <img style="width: 142px; height: 142px; left: 550px; top: 306px; position: absolute; background: linear-gradient(0deg, #0243F5 0%, #0243F5 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 9999px" src="https://via.placeholder.com/142x142">
                </div>
            </div>
        </div>
        <div class="row mb-5 ms-1" style="color: #646464; size: 20px;">
            Selamat datang di Edukas1, sumber terpercaya <br> untuk belajar mata kuliah secara efektif.
        </div>
        <button style="width: 143px; height: 60px;"class="btn btn-primary mb-5 ms-3"><a href="#" class="nav-link text-light" style="font-size:18px;">Start Now</a></button>
    </div>
    <div class="row">
        <div class="row">
            <div class="col bold" style="color: #0038CF; font-size: 16px; text-align:center;">
                Courses
            </div>
        </div>
        <div class="row">
            <div class="col bold mb-5" style="color: #101828; font-size: 36px; text-align:center;">
                Selamat Datang di Pusat Kursus EdukaS1!
            </div>
        </div>
        <div class="row mt-5" style="text-align: center;">
            <div class="col mx-2" style="border: 1px solid; box-shadow: 0px 67.11438751220703px 109.06088256835938px rgba(0, 0, 0, 0.05); border-radius: 12px;">
                a
            </div>
            <div class="col mx-2" style="border: 1px solid;">
                b
            </div>
            <div class="col mx-2" style="border: 1px solid;">
                c
            </div>
        </div>
        <div class="row mt-5">
            <div class="col" style="text-align:center;">
                <button style="width: 143px; height: 40px; text-align:center;"class="btn btn-primary mb-5 ms-3"><a href="/course" class="nav-link text-light" style="font-size:14px;">Explore Courses</a></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="col bold" style="color: #0038CF; font-size: 16px; text-align:center;">
                About Us
            </div>
        </div>
        <div class="row">
            <div class="col bold mb-5" style="color: #101828; font-size: 36px; text-align:center;">
                Pengalaman dengan Fleksibilitas Belajar!
            </div>
        </div>
        <div class="row mt-5">
            <div class="col mx-2">
                <img src="{{ asset('storage/profile_picture/default.jpg') }}" alt="" style="width: 524px; height:372px;">
            </div>
            <div class="col mx-2" >
                Selamat datang di Edukas1, sebuah destinasi belajar yang kami dedikasikan untuk pendidikan yang bermutu dan keterampilan yang berharga. Kami didirikan dengan visi untuk menjadi mitra pendidikan terpercaya bagi siswa, mahasiswa, dan profesional yang ingin meraih potensi maksimal mereka. <br><br> Di Edukas1, kami memahami bahwa pendidikan adalah fondasi untuk membangun masa depan yang sukses. Oleh karena itu, kami menawarkan berbagai kursus yang dirancang untuk memberikan pendidikan yang berkualitas dan akses mudah ke sumber daya pendidikan terkini.
            </div>
        </div>
        <div class="row mt-5">
            <div class="col" style="text-align:center;">
                <button style="width: 77px; height: 40px; text-align:center;"class="btn btn-primary mb-5 ms-3"><a href="/about" class="nav-link text-light" style="font-size:14px;">See All</a></button>
            </div>
        </div>
    </div>
@endsection