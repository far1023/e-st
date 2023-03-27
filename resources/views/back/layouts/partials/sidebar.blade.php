<aside class="main-sidebar sidebar-dark-primary">
  <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light">E-ST</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ url('beranda') }}" class="nav-link active">
            <i class="nav-icon las la-th"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('pengguna') }}" class="nav-link">
            <i class="nav-icon las la-th"></i>
            <p>
              Pengguna
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="javascript:void(0)" class="nav-link">
            <i class="nav-icon las la-tachometer-alt"></i>
            <p>
              Form Surat
              <i class="right las la-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('formulir/ganti-rugi') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>SPGR</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('formulir/kepemilikan-tanah') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>SKT</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('formulir/peta-situasi-tanah') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>Peta Situasi Tanah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('formulir/surat-situasi-tanah') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>Surat Situasi Tanah</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="javascript:void(0)" class="nav-link">
            <i class="nav-icon las la-tachometer-alt"></i>
            <p>
              Data Surat
              <i class="right las la-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ url('data/ganti-rugi') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>SPGR</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/kepemilikan-tanah') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>SKT</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/peta-situasi-tanah') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>Peta Situasi Tanah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('data/surat-situasi-tanah') }}" class="nav-link">
                <i class="las la-circle nav-icon"></i>
                <p>Surat Situasi Tanah</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</aside>
