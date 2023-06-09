<aside class="main-sidebar sidebar-dark-primary">
  <a href="/" class="brand-link">
    <span class="brand-text font-weight-light">E-ST</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">NAVIGASI UTAMA</li>
        <li class="nav-item">
          <a href="{{ url('beranda') }}" class="nav-link {{ Request::segment(1) == 'beranda' ? 'active' : '' }}">
            <i class="nav-icon las la-home"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>
        @can('access pengguna')
          <li class="nav-item">
            <a href="{{ url('pengguna') }}" class="nav-link {{ Request::segment(1) == 'pengguna' ? 'active' : '' }}">
              <i class="nav-icon las la-user-friends"></i>
              <p>
                Pengguna
              </p>
            </a>
          </li>
        @endcan
        @can('access form')
          <li class="nav-item {{ Request::segment(1) == 'formulir' ? 'menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ Request::segment(1) == 'formulir' ? 'active' : '' }}">
              <i class="nav-icon las la-edit"></i>
              <p>
                Form Surat
                <i class="right las la-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('formulir/ganti-rugi') }}" class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'ganti-rugi' ? 'active' : '' }}">
                  <i class="nav-icon las la-hand-holding-usd la-lg"></i>
                  <p>SPGR</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('formulir/kepemilikan-tanah') }}"
                  class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'kepemilikan-tanah' ? 'active' : '' }}">
                  <i class="nav-icon las la-certificate la-lg"></i>
                  <p>SKT</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('formulir/peta-situasi-tanah') }}"
                  class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'peta-situasi-tanah' ? 'active' : '' }}">
                  <i class="nav-icon las la-map la-lg"></i>
                  <p>Peta Situasi Tanah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('formulir/surat-situasi-tanah') }}"
                  class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'surat-situasi-tanah' ? 'active' : '' }}">
                  <i class="nav-icon las la-map-signs la-lg"></i>
                  <p>Surat Situasi Tanah</p>
                </a>
              </li>
            </ul>
          </li>
        @endcan
        <li class="nav-item {{ Request::segment(1) == 'data' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ Request::segment(1) == 'data' ? 'active' : '' }}">
            <i class="nav-icon las la-th"></i>
            <p>
              Data Surat
              <i class="right las la-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('data/ganti-rugi') }}" class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'ganti-rugi' ? 'active' : '' }}">
                <i class="nav-icon las la-hand-holding-usd la-lg"></i>
                <p>SPGR</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/kepemilikan-tanah') }}" class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'kepemilikan-tanah' ? 'active' : '' }}">
                <i class="nav-icon las la-certificate la-lg"></i>
                <p>SKT</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/peta-situasi-tanah') }}" class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'peta-situasi-tanah' ? 'active' : '' }}">
                <i class="nav-icon las la-map la-lg"></i>
                <p>Peta Situasi Tanah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/surat-situasi-tanah') }}"
                class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'surat-situasi-tanah' ? 'active' : '' }}">
                <i class="nav-icon las la-map-signs la-lg"></i>
                <p>Surat Situasi Tanah</p>
              </a>
            </li>
          </ul>
        </li>
        @can('access control-room')
          <li class="nav-header">CONTROL ROOM</li>
          <li class="nav-item {{ Request::segment(1) == 'controls' ? 'menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ Request::segment(1) == 'controls' ? 'active' : '' }}">
              <i class="nav-icon las la-id-card"></i>
              <p>
                ACCESS
                <i class="right las la-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('controls/roles') }}" class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                  <p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('controls/permissions') }}" class="nav-link {{ Request::segment(2) == 'permissions' ? 'active' : '' }}">
                  <p>Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('controls/access-granting') }}" class="nav-link {{ Request::segment(2) == 'access-granting' ? 'active' : '' }}">
                  <p>Access Granting</p>
                </a>
              </li>
            </ul>
          </li>
        @endcan
      </ul>
    </nav>
  </div>
</aside>
