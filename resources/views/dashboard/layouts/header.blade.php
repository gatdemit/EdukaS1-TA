<div class="align-items-center border px-1 py-3 mb-3 rounded" style="background-color: #d4dcfc;">
    <div class="my-0" style="background-color: #d4dcfc;">
        <div class="container-fluid">
            @if(session()->has('success'))
                <div class="alert alert-success  alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="d-flex col align-items-center justify-content-center text-center" style="color: #000C2E; font-family: Inter; font-weight: 700;">
                    {{ Str::title(Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['name']) }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center" style="color: #000C2E; font-family: Inter; font-weight: 700;">
                    {{ Str::title(Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['username']) }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center" style="color: #000C2E; font-family: Inter; font-weight: 700;">
                    {{ Str::title(Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['gender']) }}
                </div>
                <div class="d-flex col align-items-center justify-content-center">
                    <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" style="height: 109px; width:109px; max-height:109px; max-width:109px; border-radius:50%">
                </div>
            </div>
            <div class="row">
                <div class="d-flex col align-items-center justify-content-center text-center" style="color: #000C2E; font-family: Inter; font-weight: 700;">
                    {{ Carbon\Carbon::parse(Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['tanggal_lahir'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('jS F Y') }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center" style="color: #000C2E; font-family: Inter; font-weight: 700;">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['nomor_telp'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center" style="color: #000C2E; font-family: Inter; font-weight: 700;">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['alamat'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center">
                    <a class="btn btn-primary" href="/dashboard/{{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['username'] }}/edit" style="font-family: Inter; font-weight: 500;">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>