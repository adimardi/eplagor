<!--
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
-->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://mahkamahagung.go.id " target="_blank">
      <img src="{{asset('assets/img/logo-ct.png')}}" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white"> PERENCANAAN </span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('home') ? ' active bg-gradient-primary' : '' }}" href="{{route('home')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">dvr</span>
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
            <i class="ni ni-money-coins text-lg"></i>
          </div>
          <span class="nav-link-text ms-1">Pagu Awal</span>
        </a>
      </li>

      <li class="nav-item">
        <a data-bs-toggle="collapse" href="#baseline" class="nav-link text-white {{ request()->routeIs('baseline1.*') ? 'active' : '' }}" data-bs-toggle="collapse" aria-controls="baseline" role="button" aria-expanded="{{ request()->routeIs('baseline1.*') ? 'true' : 'false' }}">
        <span class="material-icons">add_task</span>
        <span class="nav-link-text ms-2 ps-1">Baseline</span>
        </a>
        <div class="collapse {{ request()->routeIs('baseline1.*') ? 'show' : '' }}" id="baseline">
          <ul class="nav ">
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('baseline1.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline1.index')}}">
                <span class="material-icons">view_list</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Baseline </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('baseline1.dakung.', 'all') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline1.dakung', 'all')}}">
                <span class="material-icons">folder_special</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Dukung Baseline </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('baseline3.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline3.index')}}">
              <span class="material-icons">stacked_bar_chart</span>
              <span class="sidenav-normal  ms-2  ps-1"> Rekap Baseline </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('pagu.prioritas') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.prioritas')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">grade</span>
          </div>
          <span class="nav-link-text ms-1">Skala Prioritas</span>
        </a>
      </li>

      <!-- Menu Pagu Anggaran -->
      <li class="nav-item">
        <a data-bs-toggle="collapse" href="#anggaran" class="nav-link text-white {{ request()->routeIs('pagu.anggaran') ? 'active' : '' }}" data-bs-toggle="collapse" aria-controls="anggaran" role="button" aria-expanded="{{ request()->routeIs('pagu.anggaran') ? 'true' : 'false' }}">
        <i class="ni ni-money-coins text-lg"></i>
        <span class="nav-link-text ms-2 ps-1">Pagu Indikatif</span>
        </a>
        <div class="collapse {{ request()->routeIs('pagu.anggaran') ? 'show' : '' }}" id="anggaran">
          <ul class="nav ">
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('pagu.anggaran') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.anggaran')}}">
                <span class="material-icons">view_list</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Pagu Indikatif </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('baseline1.dakung.', 'all') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline1.dakung', 'all')}}">
                <span class="material-icons">folder_special</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Dukung Pagu Indikatif </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Menu Pagu Anggaran -->
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('anggaran.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('anggaran.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-money-coins text-lg"></i>
          </div>
          <span class="nav-link-text ms-1">Pagu Anggaran</span>
        </a>
      </li>
      <!-- Menu Pagu Revisi -->
      <li class="nav-item ">
        <a class="nav-link text-white {{ request()->routeIs('revisi.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('revisi.index')}}">
          <span class="material-icons">post_add</span>
          <span class="sidenav-normal  ms-2  ps-1"> Revisi Anggaran </span>
        </a>
      </li>
      <!-- Menu Usulan ABT -->
      <li class="nav-item ">
        <a class="nav-link text-white {{ request()->routeIs('abt.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('abt.index')}}">
          <span class="material-icons">post_add</span>
          <span class="sidenav-normal  ms-2  ps-1"> Usulan ABT </span>
        </a>
      </li>

      <!-- Menu Pagu Alokasi -->
      <li class="nav-item">
        <a data-bs-toggle="collapse" href="#alokasi" class="nav-link text-white {{ request()->routeIs('pagu.alokasi') ? 'active' : '' }}" data-bs-toggle="collapse" aria-controls="alokasi" role="button" aria-expanded="{{ request()->routeIs('pagu.alokasi') ? 'true' : 'false' }}">
        <i class="ni ni-money-coins text-lg"></i>
        <span class="nav-link-text ms-2 ps-1">Pagu Alokasi</span>
        </a>
        <div class="collapse {{ request()->routeIs('pagu.alokasi') ? 'show' : '' }}" id="alokasi">
          <ul class="nav ">
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('pagu.alokasi') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.alokasi')}}">
                <span class="material-icons">view_list</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Pagu Alokasi </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('baseline1.dakung.', 'all') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline1.dakung', 'all')}}">
                <span class="material-icons">folder_special</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Dukung Pagu Alokasi </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Menu Pagu Revisi -->
      <li class="nav-item">
        <a data-bs-toggle="collapse" href="#revisi" class="nav-link text-white {{ request()->routeIs('pagu.revisi') ? 'active' : '' }}" data-bs-toggle="collapse" aria-controls="revisi" role="button" aria-expanded="{{ request()->routeIs('pagu.revisi') ? 'true' : 'false' }}">
        <i class="ni ni-money-coins text-lg"></i>
        <span class="nav-link-text ms-2 ps-1">Pagu Revisi</span>
        </a>
        <div class="collapse {{ request()->routeIs('pagu.revisi') ? 'show' : '' }}" id="revisi">
          <ul class="nav ">
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('pagu.revisi') ? ' active bg-gradient-primary' : '' }}" href="{{route('pagu.revisi')}}">
                <span class="material-icons">view_list</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Pagu Revisi </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link text-white {{ request()->routeIs('baseline1.dakung.', 'all') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline1.dakung', 'all')}}">
                <span class="material-icons">view_list</span>
                <span class="sidenav-normal  ms-2  ps-1"> Data Usulan Revisi </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!--
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('baseline1.dakung.', 'all') ? ' active bg-gradient-primary' : '' }}" href="{{route('baseline1.dakung', 'all')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">post_add</span>
          </div>
          <span class="nav-link-text ms-1">Usulan ABT</span>
        </a>
      </li>
      -->

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Usulan Kenaikan Kelas</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('usulan.kenaikankelaspa.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('usulan.kenaikankelaspa.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">trending_up</span>
          </div>
          <span class="nav-link-text ms-1">Peradilan Agama</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('usulan.kenaikankelaspn.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('usulan.kenaikankelaspn.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">trending_up</span>
          </div>
          <span class="nav-link-text ms-1">Peradilan Umum</span>
        </a>
      </li>


      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Administrator</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('user.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('user.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">people</span>
          </div>
          <span class="nav-link-text ms-1">Data User</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('akun.*') ? ' active bg-gradient-primary' : '' }}" href="{{route('akun.index')}}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <span class="material-icons">people</span>
          </div>
          <span class="nav-link-text ms-1">Rekap Akun</span>
        </a>
      </li>

    </ul>
  </div>
</aside>
