<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TestPushNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(object $notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Lapor Jalan Wonogiri')
            ->body('Notifikasi berhasil diaktifkan.')
            ->icon('/icons/icon-192.png')
            ->action('Buka Aplikasi', 'open_app')
            ->data([
                'url' => '/akun',
            ]);
    }
}