<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- plugin --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('font-awesome/css/all.css') }}">
    <script src="{{ asset('font-awesome/js/all.js') }}"></script>
    <script src="{{ asset('dist/sweetalert.min.js') }}"></script>
    <title>Toko Online</title>
</head>
<body>
    @include('backend.v_layout.nav')
    {{-- <a href="{{ Route('backend.index') }}">Beranda</a> | 
    <a href="">user</a> | 
    <a href="" onclick="event.preventDefault(); document.getElementById('out').submit();">keluar</a> --}}
    @yield('content')
    <form action="{{ Route('backend.logout') }}" id="out" method="POST">
        @csrf
    </form>
</body>
</html>