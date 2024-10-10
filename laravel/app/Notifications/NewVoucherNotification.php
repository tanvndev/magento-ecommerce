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
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'voucher',
            'voucher_id' => $this->voucher->id,
            'image' => $this->voucher->image,
            'title' => 'Voucher mới!',
            'message' => 'Chúc mừng bạn vừa nhận được mã giảm giá mới: ' . $this->voucher->name . ' Hãy áp dụng ngay!',
            'description' => $this->voucher->description
        ];
    }
}
