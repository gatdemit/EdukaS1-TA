@if(request()->segment(count(request()->segments())) != 'create')
  <div class="col-lg-4">
      <div class="card mb-4" style="background-color: rgba(0, 100, 207, 1)">
        <div class="card-body text-center">
          <img src="{{ asset('storage/' . Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['profpic']) }}" alt="avatar"
            class="rounded-circle img-fluid" style="height:150px; width: 150px;">
          <h5 class="my-3" style="color: white; font-weight: 600;">{{ Str::title(Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['name']) }}</h5>
          <p class="mb-1" style="color: white;">{{ Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['username'] }}</p>
          <p class="mb-4" style="color: white;">{{ Firebase::Auth()->getUser(Session::get('firebaseUserId'))->email }}</p>
          <div class="d-flex justify-content-center mb-2">
            <a href="/dashboard/{{ Firebase::database()->getReference("users/" . Session::get('email'))->getValue()['username'] }}/edit" class="btn btn-light">Sunting Profil</a>
          </div>
        </div>
      </div>
    
    <div class="card mb-4 mb-lg-0">
      <div class="card-body p-0">
        <ul class="list-group list-group-flush rounded-3">
          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
            <a class="nav-link text-dark align-items-center gap-2" aria-current="page" href="/dashboard" style="font-weight: 600;">
              <i class="bi bi-person-fill"></i> Profilku
            </a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
            <a class="nav-link text-dark align-items-center gap-2" aria-current="page" href="/dashboard/quiz" style="font-weight: 600;">
              <i class="bi bi-file-earmark-check"></i> Kuis
            </a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
            <a class="nav-link text-dark align-items-center gap-2" aria-current="page" href="/keranjang" style="font-weight: 600;">
              <i class="bi bi-cart-fill"></i> Keranjangku
              @if(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email') . '/Keranjang')->getSnapshot()->exists() && !Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['checkout'])
                <span class="badge rounded-pill badge-notification bg-danger">{{ Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email') . '/Keranjang')->getSnapshot()->numChildren() }}</span>
              @endif
            </a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
            <a class="nav-link text-dark align-items-center gap-2" aria-current="page" href="/dashboard/account" style="font-weight: 600;">
              <i class="bi bi-person-fill-gear"></i> Kelola Akun
            </a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
            <a class="nav-link text-dark align-items-center gap-2" aria-current="page" href="/dashboard/pesan" style="font-weight: 600;">
              <i class="bi bi-envelope-fill"></i> Pesan
            </a>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center p-3">
            <form id="logoutform" action="/logout" method="post">
              @csrf
              <a class="nav-link text-dark align-items-center gap-2" onclick="document.getElementById('logoutform').submit();" style="font-weight: 600;" href="javascript:{}"><i class="bi bi-power"></i> Keluar</a>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endif