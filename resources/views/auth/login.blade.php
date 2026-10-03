@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')

<img src="{{ asset('images/logo.png') }}"
     class="login-logo"
     alt="Logo">
     
<h2 class="fw-bold mb-5">
    Masuk
</h2>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="form-control login-input @error('email') is-invalid @enderror"
            placeholder="Masukkan email">

        @error('email')
            <div class="invalid-feedback d-block text-start mt-2">
                {{ $message }}
            </div>
        @enderror

    </div>

   <div class="mb-4">

    <div class="position-relative">

        <input 
            type="password" 
            name="password" 
            id="password"
            class="form-control login-input pe-5 @error('password') is-invalid @enderror" 
            placeholder="Masukkan kata sandi">

        <button
            type="button"
            id="togglePassword"
            class="password-toggle"
            aria-label="Tampilkan kata sandi">

            <i class="bi bi-eye"></i>

        </button>

    </div>

    @error('password')
        <div class="invalid-feedback d-block text-start mt-2">
            {{ $message }}
        </div>
    @enderror

</div>
    <div class="text-end mb-3">
    <a href="{{ route('password.request') }}"
       class="text-decoration-none small">
        Lupa kata sandi?
    </a>
</div>

    <button type="submit" class="btn login-btn">
        Masuk
    </button>

</form>

<div class="text-center mt-3">

    <small class="text-muted">
        Belum punya akun?
    </small>

    <a href="{{ route('register') }}" class="register-link">
        Registrasi di sini
    </a>

</div>

   

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';

            this.innerHTML = '<i class="bi bi-eye-slash"></i>';

            this.setAttribute(
                'aria-label',
                'Sembunyikan kata sandi'
            );

        } else {

            password.type = 'password';

            this.innerHTML = '<i class="bi bi-eye"></i>';

            this.setAttribute(
                'aria-label',
                'Tampilkan kata sandi'
            );

        }

    });

});
</script>
@endsection