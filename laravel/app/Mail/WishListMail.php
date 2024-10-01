<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WishListMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Khám phá 5 sản phẩm yêu thích của bạn tại WD-59 Shop')
            ->view('emails.wishlists.favorite-products')
            ->with([
                'user' => $this->user,
                'data' => $this->data,
            ]);
    }
}
