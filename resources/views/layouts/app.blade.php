<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Lapor Jalan')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="icon"
      type="image/png"
      href="{{ asset('images/logo.png') }}">
    <style>
        body{
            background:#F5F7FA;
            padding-bottom:80px;
        }

        .navbar-custom{
            background:#0d6efd;
        }

        .bottom-nav{
            position:fixed;
            bottom:0;
            width:100%;
            background:white;
            box-shadow:0 -2px 10px rgba(0,0,0,.08);
            z-index:999;
        }
    </style>

</head>

<body>
@include('components.header')
@include('components.bottom-nav')
@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>