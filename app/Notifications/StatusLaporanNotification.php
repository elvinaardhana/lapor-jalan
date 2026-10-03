<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class StatusLaporanNotification extends Notification
{
    use Queueable;

    protected $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(object $notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Status Laporan Diperbarui')
            ->body(
                'Laporan "' . $this->laporan->judul .
                '" sekarang berstatus ' . $this->laporan->status . '.'
            )
            ->icon('/icons/icon-192.png')
            ->action('Lihat Laporan', 'view_report')
            ->data([
                'url' => '/laporan/' . $this->laporan->id,
            ]);
    }
}