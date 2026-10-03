<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Kata Sandi | Lapor Jalan Wonogiri')
            ->greeting('Halo,')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda pada aplikasi **Lapor Jalan Wonogiri**.')
            ->line('Klik tombol di bawah ini untuk membuat kata sandi baru.')
            ->action('Reset Kata Sandi', $url)
            ->line('Tautan ini hanya berlaku selama **60 menit**.')
            ->line('Apabila Anda tidak mengajukan permintaan ini, abaikan email ini. Kata sandi Anda tidak akan berubah.')
            ->salutation('Salam hormat, Tim Lapor Jalan Wonogiri');
    }
}