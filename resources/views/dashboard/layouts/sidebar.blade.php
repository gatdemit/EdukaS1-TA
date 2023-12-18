<div class="col-lg-4">
  @if(request()->segment(count(request()->segments())) != 'edit' && 'create')
    <div class="card mb-4" style="background-color: rgba(0, 100, 207, 1)">
      <div class="card-body text-center">
        <img src="{{ asset('storage/' . Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['profpic']) }}" alt="avatar"
          class="rounded-circle img-fluid" style="height:150px; width: 150px;">
        <h5 class="my-3" style="color: white; font-weight: 600;">{{ Str::title(Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['name']) }}</h5>
        <p class="mb-1" style="color: white;">{{ Firebase::database()->getReference('users/' . Session::get('email'))->getValue()['username'] }}</p>
        <p class="mb-4" style="color: white;">{{ Firebase::Auth()->getUser(Session::get('firebaseUserId'))->email }}</p>
        <div class="d-flex justify-content-center mb-2">
          <a href="/dashboard/{{ Firebase::database()->getReference("users/" . Session::get('email'))->getValue()['username'] }}/edit" class="btn btn-light">Edit Profile</a>
        </div>
      </div>
    </div>
  @endif
  <div class="card mb-4 mb-lg-0">
    <div class="card-body p-0">
      <ul class="list-group list-group-flush rounded-3">
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" aria-current="page" href="/dashboard" style="font-weight: 600;">
            <span data-feather="home"></span>
          Profile
          </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" aria-current="page" href="/dashboard/quiz" style="font-weight: 600;">
            <span data-feather="home"></span>
          My Quiz
          </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" aria-current="page" href="/keranjang" style="font-weight: 600;">
            <span data-feather="home"></span>
          Cart
          </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" aria-current="page" href="/dashboard/account" style="font-weight: 600;">
            <span data-feather="home"></span>
          Manage Account
          </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
          <form action="/logout" method="post" class="nav-link ff-inter text-dark d-flex align-items-center gap-2">
            @csrf
            <button type="submit" class ="dropdown-item ff-inter ms-2" style="font-weight: 600;">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>