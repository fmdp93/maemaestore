<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
  @yield('title')
  </title>  
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @yield('links')
  <script src="{{ asset('js/app.js') }}" defer type="module"></script>
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
  <script src="{{ asset('js/html5-qrcode/html5-qrcode.min.js') }}" defer></script>
  <link rel="stylesheet" href="{{ asset('js/lib/jquery-ui/jquery-ui.css') }}">
  <script src="{{ asset('js/lib/jquery-ui/jquery-ui.js') }}"></script>
  @yield('content_scripts')
  @yield('header_scripts')  
  @yield('infile_style')
  
</head>
<body>
    <div id="wrapper" class="container-fluid">
    @include('layouts/header')

    @yield('content')
    
    </div>
    @include('layouts/footer')  
</body>
</html>