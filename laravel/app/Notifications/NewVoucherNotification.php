<?php

namespace App\Notifications;

use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVoucherNotification extends Notification
{
    use Queueable;

    private $voucher;

    public function __construct($voucher)
    {
        $this->voucher = $voucher;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'voucher_id' => $this->voucher->id,
            'title' => 'Voucher mới!',
            'message' => 'Bạn có voucher mới: ' . $this->voucher->name,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'voucher_id' => $this->voucher->id,
            'title' => 'Voucher mới!',
            'message' => 'Bạn có voucher mới: ' . $this->voucher->name,
        ];
    }
}
