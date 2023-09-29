<div class="align-items-center border bg-body-tertiary px-1 py-3 mb-3">
    <div class="my-0">
        <div class="container">
            <div class="row">
                <div class="d-flex col align-items-center justify-content-center text-center">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['name'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['username'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['gender'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center">
                    <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" style="height: 109px; width:109px; max-height:109px; max-width:109px; border-radius:50%">
                </div>
            </div>
            <div class="row">
                <div class="d-flex col align-items-center justify-content-center text-center">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['tanggal_lahir'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['nomor_telp'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center">
                    {{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['alamat'] }}
                </div>
                <div class="d-flex col align-items-center justify-content-center text-center">
                    <a class="btn btn-primary" href="/dashboard/{{ Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['username'] }}/edit">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>