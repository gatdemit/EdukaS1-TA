<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
        <li class="nav-item {{ request()->segment(count(request()->segments())) == null ? 'active' : '' }}">
          <a class="nav-link {{ request()->segment(count(request()->segments())) == null ? 'text-white' : 'text-dark' }} bold" aria-current="page" href="/">Beranda</a>
        </li>
        <li class="nav-item {{ request()->segment(count(request()->segments())) == 'course' ? 'active' : '' }}">
          <a class="nav-link {{ request()->segment(count(request()->segments())) == 'course' ? 'text-white' : 'text-dark' }} bold" aria-current="page" href="/course">Mata Kuliah</a>
        </li>
        <li class="nav-item {{ request()->segment(count(request()->segments())) == 'about' ? 'active' : '' }}">
          <a class="nav-link {{ request()->segment(count(request()->segments())) == 'about' ? 'text-white' : 'text-dark' }} bold" aria-current="page" href="/about">Tentang Kami</a>
        </li>
          <li class="nav-item {{ request()->segment(count(request()->segments())) == 'contact' ? 'active' : '' }}">
            <a class="nav-link {{ request()->segment(count(request()->segments())) == 'contact' ? 'text-white' : 'text-dark' }} bold" aria-current="page" href="/contact">Hubungi Kami</a>
          </li>
          @if(Session::get('user'))
            @if(Firebase::Auth()->getUser(Session::get('firebaseUserId'))->customClaims['role']=='user')
              <li class="nav-item dropdown-center show" style="margin-right: 60px;">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" style="height: 30px; width:30px; max-height:86px; max-width:86px; border-radius:50%">
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/dashboard" style="font-weight:800;"><i class="bi bi-person-fill"></i> Profilku</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/dashboard/quiz" style="font-weight:800;"><i class="bi bi-file-earmark-check"></i> Kuis</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/dashboard/account" style="font-weight:800;"><i class="bi bi-person-fill-gear"></i> Kelola Akun</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/keranjang" style="font-weight:800;"><i class="bi bi-cart-fill"></i> Keranjangku</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="post">
                      @csrf
                      <button type="submit" class ="dropdown-item" style="font-weight:800;"><i class="bi bi-power"></i> Keluar</button>
                    </form>
                  </li>
                </ul>
              </li>
            @else
              <li>
                <form action="/logout" method="post">
                  @csrf
                  <button class="btn btn-danger">Logout</button>
                </form>
              </li>
            @endif
          @else
            <li class="nav-item {{ request()->segment(count(request()->segments())) == 'login' ? 'active' : '' }}">
              <a class="nav-link {{ request()->segment(count(request()->segments())) == 'login' ? 'text-white' : 'text-dark' }} bold" aria-current="page" href="/login">Masuk</a>
            </li>
            <li class="nav-item {{ request()->segment(count(request()->segments())) == 'register' ? 'active' : '' }}" style="margin-right:60px;">
              <a class="nav-link {{ request()->segment(count(request()->segments())) == 'register' ? 'text-white' : 'text-dark' }} bold" aria-current="page" href="/register">Daftar</a>
            </li>
          @endif
      </ul>
  </div>
</nav> 