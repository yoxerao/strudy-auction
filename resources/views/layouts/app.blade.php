<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/payment.css') }}" rel="stylesheet">
  <script type="text/javascript">
    // Fix for Firefox autofocus CSS bug
    // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
  </script>
  <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
  <script type="text/javascript" src={{ asset('js/timer.js') }} defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="body">
  <main>
    <header class="p-3">
      <h1><a class=" text-danger" href="{{ url('/') }}">eAuction</a></h1>
      @if (Auth::guard('admin')->check())
      <a class="btn btn-danger btn-lg" href="{{ url('/logout') }}"> Logout </a>
      <a href="/user/{{ Auth::guard('admin')->user()->id }}"> {{ Auth::guard('admin')->user()->name }}</a>
      @elseif (Auth::check())
      <a class="btn btn-danger btn-lg" href="{{ url('/logout') }}"> Logout </a>
      <a class="text-dark pe-5" href="/user/{{ Auth::user()->id }}"> {{ Auth::user()->name }}</a>
      @else
      <a class="btn btn-danger btn-lg" href="{{ url('/login') }}"> Login </a>
      <a class="btn btn-danger btn-lg" href="{{ url('/register') }}"> Register </a>
      @endif
    </header>
    <div class="full-height">
      <section id="content">
        @yield('content')
    </div>
    </section>
  </main>

  <footer class="footer" style="text-align:center;">
    <a class="btn btn-danger btn-lg" href="{{ url('/about') }}"> About us </a>
    <a class="btn btn-danger btn-lg" href="{{ url('/faq') }}"> FAQ's </a>
  </footer>
</body>

</html>