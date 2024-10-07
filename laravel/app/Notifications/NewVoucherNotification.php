<?php

namespace App\Notifications;

use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVoucherNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $voucher;


    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // database giup luu vao bang notifications va droadcast gui event toi client
        return ['database', 'broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'voucher_id' => $this->voucher->id,
            'title' => 'Voucher mới!',
            'message' => 'Bạn có voucher mới: ' . $this->voucher->name,
            'created_at' => now()->toISOString(),
        ]);
    }

    // Phuong thuc nay dinh dang lai thong bao de luu vao bang notifications
    public function toArray($notifiable)
    {
        return [
            'voucher_id' => $this->voucher->id,
            'title' => 'Voucher mới!',
            'message' => 'Bạn có voucher mới: ' . $this->voucher->name,
        ];
    }
}
