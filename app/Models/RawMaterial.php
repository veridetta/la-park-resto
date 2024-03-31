<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RawMaterial extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'raw_materials';
    protected $fillable = [
        'name',
        'qty',
        'limit',
        'unit',
        'price',
    ];

    public function requirementRawMaterials()
    {
        return $this->hasMany(RequirementRawMaterial::class);
    }

    public function rawMaterialHistories()
    {
        return $this->hasMany(RawMaterialHistory::class);
    }
}
