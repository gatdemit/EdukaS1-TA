<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
  <div class="offcanvas-lg offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel" style="color: black; font-weight: 600;">
            Admin Panel
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel/users" style="color: black; font-weight: 600;">
            Users
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel/fakultas" style="color: black; font-weight: 600;">
            Fakultas dan Jurusan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel/video" style="color: black; font-weight: 600;">
            Videos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel/quiz" style="color: black; font-weight: 600;">
            Quiz
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel/transaksi" style="color: black; font-weight: 600;">
            Transactions
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="/adPanel/laporan" style="color: black; font-weight: 600;">
            Reports
          </a>
        </li>
      </ul>

      <hr class="my-3">

      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <form action="/logout" method="post">
            @csrf
            <button type="submit" class ="nav-link d-flex align-items-center gap-2" style="color: black;font-weight: 600;"> Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>