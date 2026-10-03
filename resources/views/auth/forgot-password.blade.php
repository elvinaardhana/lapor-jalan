@extends('layouts.auth')

@section('title','Lupa Password')

@section('content')

<img src="{{ asset('images/logo.png') }}"
     class="login-logo"
     alt="Logo">

<h2 class="fw-bold mb-4">
 Reset Password</h2>

<p class="text-muted mb-4">
    Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
</p>

@if(session('status'))

<div class="alert alert-success">
    {{ session('status') }}
</div>

@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-4">

        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="form-control login-input @error('email') is-invalid @enderror"
            placeholder="Masukkan email">

        @error('email')
            <div class="invalid-feedback d-block mt-2">
                {{ $message }}
            </div>
        @enderror

    </div>

    <button class="btn forgot-btn">
        Kirim Link Reset
    </button>

</form>

<div class="text-center mt-4">

    <a href="{{ route('login') }}" class="register-link">
        ← Kembali ke Login
    </a>

</div>

@endsection