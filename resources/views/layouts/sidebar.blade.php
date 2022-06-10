<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://mahkamahagung.go.id " target="_blank">
      <img src="{{asset('assets/img/logo-ct.png')}}" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white">Perencanaan</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('home') ? ' active bg-gradient-primary' : '' }}" href="{{route('home')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pagu</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pagu.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.index')}}"">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Pagu Awal</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('baseline.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Baseline</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('baseline.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Data Dukung Baseline</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pagu.prioritas') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.prioritas')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Skala Prioritas</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pagu.indikatif') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.indikatif')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Pagu Indikatif</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pagu.definitif') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.definitif')}}"">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Pagu Definitif</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kenaikan Kelas</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pagu.prioritas') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.prioritas')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Usulan Kenaikan Kelas</span>
        </a>
      </li>


      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Administrator</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('user.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('user.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Data User</span>
        </a>
      </li>

    </ul>
  </div>
</aside>
