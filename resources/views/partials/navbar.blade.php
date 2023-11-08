<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-dark bold" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark bold" aria-current="page" href="/course">Course</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark bold" aria-current="page" href="/about">About</a>
        </li>
          <li class="nav-item">
            <a class="nav-link text-dark bold" aria-current="page" href="/contact">Contact</a>
          </li>
          @if(Session::get('user'))
          <li class="nav-item dropdown show">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{ asset('storage/'. Firebase::database()->getReference('users/'.Session::get('email'))->getValue()['profpic']) }}" style="height: 86px; width:86px; max-height:86px; max-width:86px; border-radius:50%">
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/dashboard">My Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/dashboard/quiz">My Quiz</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/dashboard/account">Manage Account</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/keranjang">Keranjangku</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="/logout" method="post">
                  @csrf
                  <button type="submit" class ="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          </li>
          @else
            <li class="nav-item">
              <a class="nav-link text-dark bold" aria-current="page" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light bold activate" aria-current="page" href="/register">Sign Up</a>
            </li>
          @endif
      </ul>
  </div>
</nav> 