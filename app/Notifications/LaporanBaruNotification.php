<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class LaporanBaruNotification extends Notification
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
            ->title('Laporan Kerusakan Baru')
            ->body('Ada laporan baru: ' . $this->laporan->judul)
            ->icon('/icons/icon-192.png')
            ->action('Lihat Laporan', 'view_report')
            ->data([
                'url' => '/admin/laporan/' . $this->laporan->id,
            ]);
    }
}