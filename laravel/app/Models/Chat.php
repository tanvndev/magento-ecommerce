<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Chat extends Model
{
    use HasFactory, Notifiable, QueryScopes;

    protected $fillable = [
        'message',
        'sender_id',
        'receiver_id',
        'read_at',
        'images'
    ];


    protected $casts = [
        'images' => 'array'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
