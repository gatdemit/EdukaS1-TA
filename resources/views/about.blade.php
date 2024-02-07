@extends('layouts.main')

@section('container')
<div class="container">
    <div class="row mt-5">
        <div class="col" style="margin-right: 40px; display: flex; flex-direction: column; justify-content: center">
            <h1 class="text-primary" style="font-weight:600; font-size: 36px;">Tentang Edukas1</h1>
            <p>Kami di Edukas1 berkomitmen untuk memberikan pendidikan berkualitas tinggi dan aksesibel kepada semua orang. Kami percaya bahwa pendidikan adalah kunci untuk pertumbuhan dan kemajuan pribadi, dan kami berdedikasi untuk membantu mahasiswa mencapai potensi terbaik mereka.</p>
            <p>Edukas1 adalah sebuah platform pendidikan daring yang berfokus pada penyediaan beragam kursus mata kuliah untuk mahasiswa. Kami adalah tim berdedikasi yang terdiri dari pengajar berkualitas, desainer instruksional, dan pengembang web yang bersemangat tentang memberikan pengalaman belajar terbaik kepada pengguna kami.</p>
        </div>
        <div class="col">
            <img src="{{ asset('storage/asset/About_1.jpeg') }}" alt="" style="width: 100%; height: 100%;">
        </div>
    </div>
    <div class="row mt-5">
        <div class="col" style="margin-right: 40px;">
            <img src="{{ asset('storage/asset/About_2.jpeg') }}" alt="" style="width: 100%; height: 100%;">
        </div>
        <div class="col" style="display: flex; flex-direction: column; justify-content: center">
            <h1 class="text-primary" style="font-weight:600; font-size: 36px;">Apa Yang Kami Tawarkan?</h1>
            <p>Kami menawarkan beragam kursus dari berbagai mata kuliah yang diajarkan oleh instruktur berpengalaman. Setiap kursus dirancang dengan cermat untuk memastikan pengalaman belajar yang efektif dan menarik. Di sini, Anda dapat mengakses:</p>
            <ul>
                <li>Kursus Interaktif: Kursus kami dirancang untuk memungkinkan Anda belajar dengan cara yang paling sesuai dengan Anda, dengan konten yang mendalam dan materi yang relevan.</li>
                <li>Dukungan Pengajar: Kami memiliki pengajar yang siap membantu Anda dalam setiap langkah perjalanan belajar Anda.</li>
                <li>Komunitas Belajar: Bergabung dengan komunitas mahasiswa kami, diskusikan pertanyaan, dan saling berbagi pengalaman.</li>
            </ul>
        </div>
    </div>
</div>
@endsection