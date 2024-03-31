<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CashFlow extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'cash_flows';
    protected $fillable = [
        'date',
        'description',
        'in',
        'out',
        'balance',
        'sales_no',
        'category', //biaya produksi, pendapatan, biaya lainnya
    ];

    public function salesx()
    {
        return $this->belongsTo(Sales::class, 'sales_no', 'sales_no');
    }
}
