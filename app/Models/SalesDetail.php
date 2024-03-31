<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SalesDetail extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'sales_details';
    protected $fillable = [
        'sales_id',
        'menu_id',
        'qty',
        'price'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

}
