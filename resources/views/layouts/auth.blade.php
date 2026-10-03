<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="icon"
      type="image/png"
      href="{{ asset('images/logo.png') }}">
    <style>

body{
    margin:0;
    background:#eceff3;
    font-family:'Segoe UI',sans-serif;
}
.password-toggle {
    position: absolute;
    top: 50%;
    right: 14px;
    transform: translateY(-50%);

    border: none;
    background: transparent;

    color: #6c757d;

    padding: 5px;

    cursor: pointer;

    font-size: 18px;
}

.password-toggle:hover {
    color: #0d6efd;
}
.mobile{

    width:100%;
    max-width:430px;

    margin:auto;

    min-height:100vh;

    background:white;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;

}

.auth-content{
    width:100%;
    max-width:300px;
    text-align:center;
}
.auth-content h2{
    font-size: 27px;
    margin-top:30px !important;
    margin-bottom:50px !important;
}
.login-logo{
    width:120px;
    height:auto;
}

.login-input{

    height:48px;

    border:none;

    border-radius:28px;

    background:#fff;

    padding:0 18px;
    font-size:14px;

    box-shadow:0 4px 12px rgba(0,0,0,.12);

}

.login-input:focus{

    border:none;

    box-shadow:0 0 0 .18rem rgba(78,104,140,.18);

}

.login-btn{
    height:42px;
    width:38%;          /* lebar tombol */
    margin:0 auto;        /* supaya tetap di tengah */
    display:block;
    margin-top:35px;    /* jarak atas tombol */
    border:none;
    border-radius:22px;

    color:#4E688C;
   background:#fff;

    font-size:15px;
    font-weight:600;

    box-shadow:0 2px 6px rgba(0,0,0,.12);
}

.login-btn:hover{

    background:#435b7a;

    color:white;

}
.forgot-btn{
    height:42px;
    width:60%;          /* lebar tombol */
    margin:0 auto;        /* supaya tetap di tengah */
    display:block;
    margin-top:35px;    /* jarak atas tombol */
    border:none;
    border-radius:22px;

    color:#4E688C;
   background:#fff;

    font-size:15px;
    font-weight:600;

    box-shadow:0 2px 6px rgba(0,0,0,.12);
}

.forgot-btn:hover{

    background:#435b7a;

    color:white;

}
.register-link{

    color:#6882A6;

    text-decoration:none;

    font-weight:600;

}

.register-link:hover{

    color:#1E3F6F;
    font-weight:650;

}
.text-center small{
    font-size:13px;
}

.register-link{
    font-size:13px;
    font-weight:600;
}

.invalid-feedback{

    font-size:13px;

}
/* SweetAlert Mobile */
.swal2-popup{
    width:90% !important;
    max-width:320px !important;
    border-radius:18px !important;
    padding:1.4rem !important;
}

.swal2-title{
    font-size:1.35rem !important;
    font-weight:700 !important;
}

.swal2-html-container{
    font-size:.95rem !important;
    line-height:1.5;
}

.swal2-icon{
    transform:scale(.8);
    margin:0.5rem auto !important;
}

.swal2-confirm{
    border-radius:12px !important;
    padding:.55rem 1.6rem !important;
    font-size:.95rem !important;
}


    </style>

</head>

<body>
@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Login Gagal',
    text:'{{ $errors->first() }}'
});
</script>
@endif

@if(session('register_success'))
<script>
Swal.fire({
    icon:'success',
    title:'Registrasi Berhasil',
    text:'{{ session("register_success") }}',
    confirmButtonColor:'#2563eb'
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Registrasi Gagal',
    text:'{{ $errors->first() }}'
});
</script>
@endif

<div class="mobile">

    <div class="auth-content">

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: '{{ request()->routeIs("register") ? "Registrasi Gagal" : "Login Gagal" }}',
    text: '{{ $errors->first() }}',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'OK'
});
</script>
@endif

@yield('scripts')
 

</body>

</html>