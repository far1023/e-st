<aside class="main-sidebar sidebar-dark-primary">
  <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light">E-ST</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">NAVIGASI UTAMA</li>
        <li class="nav-item">
          <a href="{{ url('beranda') }}" class="nav-link {{ Request::segment(1) == 'beranda' ? 'active' : '' }}">
            <i class="nav-icon las la-th"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('pengguna') }}" class="nav-link {{ Request::segment(1) == 'pengguna' ? 'active' : '' }}">
            <i class="nav-icon las la-th"></i>
            <p>
              Pengguna
            </p>
          </a>
        </li>
        <li class="nav-item {{ Request::segment(1) == 'formulir' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ Request::segment(1) == 'formulir' ? 'active' : '' }}">
            <i class="nav-icon las la-tachometer-alt"></i>
            <p>
              Form Surat
              <i class="right las la-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('formulir/ganti-rugi') }}" class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'ganti-rugi' ? 'active' : '' }}">
                &emsp;&emsp;<p>SPGR</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('formulir/kepemilikan-tanah') }}"
                class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'kepemilikan-tanah' ? 'active' : '' }}">
                &emsp;&emsp;<p>SKT</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('formulir/peta-situasi-tanah') }}"
                class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'peta-situasi-tanah' ? 'active' : '' }}">
                &emsp;&emsp;<p>Peta Situasi Tanah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('formulir/surat-situasi-tanah') }}"
                class="nav-link {{ Request::segment(1) == 'formulir' && Request::segment(2) == 'surat-situasi-tanah' ? 'active' : '' }}">
                &emsp;&emsp;<p>Surat Situasi Tanah</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item {{ Request::segment(1) == 'data' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ Request::segment(1) == 'data' ? 'active' : '' }}">
            <i class="nav-icon las la-tachometer-alt"></i>
            <p>
              Data Surat
              <i class="right las la-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('data/ganti-rugi') }}" class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'ganti-rugi' ? 'active' : '' }}">
                &emsp;&emsp;<p>SPGR</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/kepemilikan-tanah') }}" class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'kepemilikan-tanah' ? 'active' : '' }}">
                &emsp;&emsp;<p>SKT</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/peta-situasi-tanah') }}" class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'peta-situasi-tanah' ? 'active' : '' }}">
                &emsp;&emsp;<p>Peta Situasi Tanah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/surat-situasi-tanah') }}"
                class="nav-link {{ Request::segment(1) == 'data' && Request::segment(2) == 'surat-situasi-tanah' ? 'active' : '' }}">
                &emsp;&emsp;<p>Surat Situasi Tanah</p>
              </a>
            </li>
          </ul>
        </li>
        @can('access control-room')
          <li class="nav-header">CONTROL ROOM</li>
          <li class="nav-item {{ Request::segment(1) == 'controls' ? 'menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ Request::segment(1) == 'controls' ? 'active' : '' }}">
              <i class="nav-icon las la-tachometer-alt"></i>
              <p>
                ACCESS
                <i class="right las la-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('controls/roles') }}" class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                  &emsp;&emsp;<p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('controls/permissions') }}" class="nav-link {{ Request::segment(2) == 'permissions' ? 'active' : '' }}">
                  &emsp;&emsp;<p>Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('controls/access-granting') }}" class="nav-link {{ Request::segment(2) == 'access-granting' ? 'active' : '' }}">
                  &emsp;&emsp;<p>Access Granting</p>
                </a>
              </li>
            </ul>
          </li>
        @endcan
      </ul>
    </nav>
  </div>
</aside>
