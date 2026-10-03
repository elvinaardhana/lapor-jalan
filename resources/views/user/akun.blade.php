@extends('layouts.mobile')

@section('title','Akun')

@section('content')

@if(!Auth::check())

<div class="container py-5 text-center">

    <div class="profile-avatar-empty">

        <i class="bi bi-person-fill"></i>

    </div>

    <h4 class="fw-bold mt-4">
        Anda belum masuk
    </h4>

    <p class="text-muted mb-4">
        Masuk untuk melihat informasi akun,
        status laporan, dan mengirim laporan.
    </p>

    <a href="{{ route('login') }}"
       class="btn btn-login-akun">

        Masuk

    </a>

    <div class="mt-4">

        <small class="text-muted">

            Belum punya akun?

        </small>

        <br>

        <a href="{{ route('register') }}"
           class="register-link">

            Daftar

        </a>

    </div>

</div>

@else

@php

$nama = explode(' ', trim(Auth::user()->name));

$inisial = strtoupper(substr($nama[0],0,1));

if(count($nama)>1){
    $inisial .= strtoupper(substr(end($nama),0,1));
}

@endphp

<div class="container py-3">

    <div class="text-center mb-4">

        <div class="profile-avatar">

            {{ $inisial }}

        </div>

        <h4 class="fw-bold mt-3">

            {{ Auth::user()->name }}

        </h4>

        <p class="text-muted">

            {{ Auth::user()->email }}

        </p>

    </div>

    <div class="profile-card">

    <div class="d-flex justify-content-between align-items-center">
    
        <div>
    
            <small class="text-muted">
                Jumlah Laporanmu
            </small>
    
            <h3 class="fw-bold mb-0">
                {{ $jumlahLaporan }}
            </h3>
    
        </div>
    
        <div class="card-icon">
    
            <i class="bi bi-file-earmark-text"></i>
    
        </div>
    
    </div>

</div>

    <a href="{{ route('laporan.saya') }}"
  
   class="profile-card text-decoration-none text-dark">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <small class="text-muted">
                Status Laporanmu
            </small>
        </div>

        <i class="bi bi-chevron-right fs-5"></i>

    </div>

</a>


<!--{{-- NOTIFIKASI --}}-->
<div class="profile-card mt-3">

    <div class="d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">

            <div class="card-icon me-3">
                <i class="bi bi-bell-fill"></i>
            </div>

            <div>
                <div class="fw-semibold">
                    Notifikasi
                </div>

                <small class="text-muted"
                       id="notificationStatus">
                    Aktifkan untuk menerima pembaruan laporan
                </small>
            </div>

        </div>

        <button type="button"
                class="btn btn-primary btn-sm"
                id="btnEnableNotification">
            Aktifkan
        </button>

    </div>

</div>


<!--{{-- DASHBOARD ADMIN --}}-->
@if(Auth::user()->role == 'admin')

<a href="{{ route('admin.dashboard') }}"
   class="admin-card text-decoration-none">

    <div class="d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">

            <div class="admin-icon me-3">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div>

                <div class="fw-bold text-white">
                    Dashboard Admin
                </div>

                <small class="text-white-50">
                    Kelola laporan dan sistem
                </small>

            </div>

        </div>

        <i class="bi bi-arrow-right-circle-fill text-white fs-4"></i>

    </div>

</a>

@endif

    <form action="{{ route('logout') }}"
          method="POST"
          class="text-center mt-5">

        @csrf

        <button class="btn-logout">
    Keluar
</button>
    </form>

</div>

@endif

@endsection

<!----notifikasi js>-->
@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('btnEnableNotification');
    const status = document.getElementById('notificationStatus');

    if (!button) return;

    // Cek dukungan Web Push
    if (
        !('serviceWorker' in navigator) ||
        !('PushManager' in window) ||
        !('Notification' in window)
    ) {
        button.disabled = true;
        status.textContent = 'Notifikasi tidak didukung pada perangkat ini';
        return;
    }

    // Cek apakah perangkat sudah memiliki subscription
    navigator.serviceWorker.ready.then(async registration => {

        const subscription =
            await registration.pushManager.getSubscription();

        if (subscription) {
            button.textContent = 'Nonaktifkan';
            button.disabled = false;
            status.textContent = 'Notifikasi telah diaktifkan';
        }

    });

    button.addEventListener('click', async function () {

        try {

            button.disabled = true;
            button.textContent = 'Memproses...';

            const registration =
                await navigator.serviceWorker.ready;

            const existingSubscription =
                await registration.pushManager.getSubscription();


            // =====================================
            // NONAKTIFKAN NOTIFIKASI
            // =====================================

            if (existingSubscription) {

                const endpoint = existingSubscription.endpoint;

                const response = await fetch(
                    '{{ route('push.unsubscribe') }}',
                    {
                        method: 'DELETE',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            endpoint: endpoint
                        })
                    }
                );

                if (!response.ok) {
                    throw new Error(
                        'Gagal menghapus subscription'
                    );
                }

                await existingSubscription.unsubscribe();

                button.textContent = 'Aktifkan';
                button.disabled = false;

                status.textContent =
                    'Aktifkan untuk menerima pembaruan laporan';

                return;
            }


            // =====================================
            // AKTIFKAN NOTIFIKASI
            // =====================================

            const permission =
                await Notification.requestPermission();

            if (permission !== 'granted') {

                status.textContent =
                    'Izin notifikasi tidak diberikan';

                button.textContent = 'Aktifkan';
                button.disabled = false;

                return;
            }

            const vapidPublicKey =
                @json(config('webpush.vapid.public_key'));

            const subscription =
                await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey:
                        urlBase64ToUint8Array(vapidPublicKey)
                });

            const subscriptionData =
                subscription.toJSON();

            const response = await fetch(
                '{{ route('push.subscribe') }}',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':
                            '{{ csrf_token() }}'
                    },

                    body: JSON.stringify({
                        endpoint:
                            subscriptionData.endpoint,

                        keys:
                            subscriptionData.keys,

                        content_encoding:
                            (PushManager.supportedContentEncodings ||
                            ['aes128gcm'])[0]
                    })
                }
            );

            if (!response.ok) {
                throw new Error(
                    'Gagal menyimpan subscription'
                );
            }

            button.textContent = 'Nonaktifkan';
            button.disabled = false;

            status.textContent =
                'Notifikasi telah diaktifkan';

        } catch (error) {

            console.error(
                'Push notification error:',
                error
            );

            button.textContent = 'Aktifkan';
            button.disabled = false;

            status.textContent =
                'Gagal memproses notifikasi';
        }

    });

});


function urlBase64ToUint8Array(base64String) {

    const padding =
        '='.repeat(
            (4 - base64String.length % 4) % 4
        );

    const base64 =
        (base64String + padding)
            .replace(/-/g, '+')
            .replace(/_/g, '/');

    const rawData =
        window.atob(base64);

    return Uint8Array.from(
        [...rawData].map(
            char => char.charCodeAt(0)
        )
    );
}
</script>

@endsection