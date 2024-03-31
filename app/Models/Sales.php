<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sales extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'sales';
    protected $fillable = [
        'date',
        'total',
        'customer',
        'user_id',
        'sales_no',
        'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function cashFlow()
    {
        return $this->hasOne(CashFlow::class);
    }


}
