@extends('layouts.auth')

@section('title', 'Register')

@section('content')



<h2 class="fw-bold mb-4">
    Registrasi Akun
</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">

        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="form-control login-input @error('name') is-invalid @enderror"
            placeholder="Masukkan nama pengguna">

        @error('name')
            <div class="invalid-feedback d-block text-start mt-2">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="mb-3">

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

   <div class="mb-3">

    <div class="position-relative">

        <input 
            type="password" 
            name="password" 
            id="password"
            class="form-control login-input pe-5 @error('password') is-invalid @enderror" 
            placeholder="Masukkan kata sandi">

        <button
            type="button"
            class="password-toggle"
            id="togglePassword"
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


<div class="mb-4">

    <div class="position-relative">

        <input 
            type="password" 
            name="password_confirmation" 
            id="password_confirmation"
            class="form-control login-input pe-5" 
            placeholder="Konfirmasi kata sandi">

        <button
            type="button"
            class="password-toggle"
            id="togglePasswordConfirmation"
            aria-label="Tampilkan konfirmasi kata sandi">

            <i class="bi bi-eye"></i>

        </button>

    </div>

</div>

    <button type="submit" class="btn login-btn">
        Registrasi
    </button>

</form>

<div class="text-center mt-3">

    <small class="text-muted">
        Sudah punya akun?
    </small>

    <a href="{{ route('login') }}"
       class="register-link">
        Masuk
    </a>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Password
    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';

            this.innerHTML = '<i class="bi bi-eye-slash"></i>';

        } else {

            password.type = 'password';

            this.innerHTML = '<i class="bi bi-eye"></i>';

        }

    });


    // Konfirmasi Password
    const passwordConfirmation =
        document.getElementById('password_confirmation');

    const togglePasswordConfirmation =
        document.getElementById('togglePasswordConfirmation');

    togglePasswordConfirmation.addEventListener('click', function () {

        if (passwordConfirmation.type === 'password') {

            passwordConfirmation.type = 'text';

            this.innerHTML = '<i class="bi bi-eye-slash"></i>';

        } else {

            passwordConfirmation.type = 'password';

            this.innerHTML = '<i class="bi bi-eye"></i>';

        }

    });

});
</script>
@endsection