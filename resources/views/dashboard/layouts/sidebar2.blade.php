<div class="sidebar p-0 bg-body-tertiary">
  <div class="offcanvas-lg offcanvas-end bg-body-tertiary rounded" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto" style="min-height: 500px;">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" aria-current="page" href="/dashboard" style="font-weight: 600;">
              <span data-feather="home"></span>
            My Profile
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" href="/dashboard/quiz" style="font-weight: 600;">
              <span data-feather="file-text"></span>
            My Quiz
          </a>
        </li> 
        <li class="nav-item">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" href="/keranjang" style="font-weight: 600;">
              <span data-feather="file-text"></span>
            My Cart
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link ff-inter text-dark d-flex align-items-center gap-2" href="/dashboard/account" style="font-weight: 600;">
              <span data-feather="file-text"></span>
            Manage Account
          </a>
        </li>
        <li class="nav-item">
          <form action="/logout" method="post" class="nav-link ff-inter text-dark d-flex align-items-center gap-2">
              @csrf
              <button type="submit" class ="dropdown-item ff-inter ms-2" style="font-weight: 600;">Logout</button>
            </form>
        </li>
      </ul>
    </div>
  </div>
</div>