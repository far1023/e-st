<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <base href="../">
  <title>{{ $title }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('template/plugins/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('template/dist/css/adminlte.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('template/plugins/iziToast/css/iziToast.min.css') }}" rel="stylesheet" />
  @if ($css)
    @foreach ($css as $item)
      @include('back.extcss.' . $item)
    @endforeach
  @endif
</head>


<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    @include('back.layouts.partials.navbar')
    @include('back.layouts.partials.sidebar')

    <div class="content-wrapper pb-5">
      @yield('content')
    </div>

    @include('back.layouts.partials.footer')
  </div>

  <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('template/plugins/iziToast/js/iziToast.min.js') }}"></script>
  @if ($js)
    @include('back.extjs.' . $js)
  @endif
</body>

</html>
