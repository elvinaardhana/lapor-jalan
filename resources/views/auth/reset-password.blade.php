@extends('layouts.auth')

@section('title','Reset Password')

@section('content')

<img src="{{ asset('images/logo.png') }}"
     class="login-logo"
     alt="Logo">

<h2 class="fw-bold mb-4">
    Reset Password
</h2>

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input
        type="hidden"
        name="token"
        value="{{ $token }}">

    <div class="mb-3">

        <input
            type="email"
            name="email"
            value="{{ $email }}"
            class="form-control login-input"
            placeholder="Email">

    </div>

    <div class="mb-3">

        <input
            type="password"
            name="password"
            class="form-control login-input"
            placeholder="Password Baru">

    </div>

    <div class="mb-4">

        <input
            type="password"
            name="password_confirmation"
            class="form-control login-input"
            placeholder="Konfirmasi Password">

    </div>

    <button class="btn forgot-btn">
        Simpan Password Baru
    </button>

</form>

@endsection