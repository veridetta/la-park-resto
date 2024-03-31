<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Menu extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'menus';
    protected $fillable = [
        'name',
        'category',
        'price',
        'image'
    ];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function requirementRawMaterials()
    {
        return $this->hasMany(RequirementRawMaterial::class);
    }
}
