<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-ST | Log in</title>

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet" />
  <link href="{{ asset('template/plugins/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('template/dist/css/adminlte.min.css') }}" rel="stylesheet" />
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      Pembuatan Surat Tanah
    </div>
    <div class="card">
      <div class="card-body login-card-body p-0">
        <p class="login-box-msg p-3">Silahkan masuk dengan akun Anda</p>

        @if (session()->has('loginError'))
          <div class="alert alert-danger alert-dismissible text-sm border-radius-0">
            <button type="button" class="close text-white" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
            {{ session('loginError') }}
          </div>
        @endif

        <form action="/login" method="POST" class="p-3">
          @csrf
          <div class="input-group mt-1">
            <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control @error('username') border border-danger @enderror"
              placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text @error('username') border border-danger @enderror">
                <span class="las la-user"></span>
              </div>
            </div>
          </div>
          @error('username')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
          <div class="input-group mt-3">
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control @error('password') border border-danger @enderror"
              placeholder="Kata Sandi">
            <div class="input-group-append">
              <div class="input-group-text @error('password') border border-danger @enderror">
                <span class="las la-lock"></span>
              </div>
            </div>
          </div>
          @error('password')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
          <div class="my-3 float-right">
            <button type="submit" class="btn btn-primary px-4">Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
