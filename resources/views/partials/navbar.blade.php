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
                <a data-mdb-ripple-init class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" style="height: 30px; width:30px; max-height:86px; max-width:86px; border-radius:50%">
                  @if(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email') . '/Keranjang')->getSnapshot()->exists() && !Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['checkout'])
                    <span class="badge rounded-pill badge-notification bg-danger"><i class="bi bi-cart-fill"></i>{{ Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email') . '/Keranjang')->getSnapshot()->numChildren() }}</span>
                  @endif
                  @if(Firebase::database()->getReference('message/received/' . Session::get('email'))->getSnapshot()->exists())
                    @php
                      $count = 0;
                      foreach(Firebase::database()->getReference('message/received/' . Session::get('email'))->getValue() as $sender){
                        foreach($sender['message'] as $pesan){
                          if(!$pesan['read']){
                            $count += 1;
                          }
                        }
                      }
                    @endphp
                    @if($count > 0)
                      <span class="badge rounded-pill badge-notification bg-danger"><i class="bi bi-envelope-fill"></i>{{ $count }}</span>
                    @endif
                  @endif
                </a>
                
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/dashboard" style="font-weight:800;"><i class="bi bi-person-fill"></i> Profilku</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/dashboard/quiz" style="font-weight:800;"><i class="bi bi-file-earmark-check"></i> Kuis</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/dashboard/account" style="font-weight:800;"><i class="bi bi-person-fill-gear"></i> Kelola Akun</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/keranjang" style="font-weight:800;"><i class="bi bi-cart-fill"></i> 
                  Keranjangku
                  @if(Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email') . '/Keranjang')->getSnapshot()->exists() && !Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email'))->getValue()['checkout'])
                    <span class="badge rounded-pill badge-notification bg-danger">{{ Firebase::database()->getReference('transaksi/unvalidated/' . Session::get('email') . '/Keranjang')->getSnapshot()->numChildren() }}</span>
                  @endif
                </a>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" aria-current="page" href="/dashboard/pesan" style="font-weight: 800;">
                    <i class="bi bi-envelope-fill"></i> Pesan 
                    @if(Firebase::database()->getReference('message/received/' . Session::get('email'))->getSnapshot()->exists())
                      @if($count > 0)
                        <span class="badge rounded-pill badge-notification bg-danger">
                          {{ $count }}
                        </span>
                      @endif
                    @endif
                  </a>
                </li>  
                </li>
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