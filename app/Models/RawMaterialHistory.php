<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RawMaterialHistory extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'raw_material_histories';
    protected $fillable = [
        'date',
        'raw_material_id',
        'in',
        'out',
        'description',
        'balance',
        'price',
    ];

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function requirementRawMaterial()
    {
        return $this->hasOne(RequirementRawMaterial::class);
    }
}
