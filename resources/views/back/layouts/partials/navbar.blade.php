<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="las la-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="lar la-user-circle la-lg"></i> {{ Auth::user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ url('logout') }}" class="dropdown-item">
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
