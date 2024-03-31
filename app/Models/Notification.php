<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'title',
        'content',
        'type', //type sales, raw_material, user
        'user_id',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
