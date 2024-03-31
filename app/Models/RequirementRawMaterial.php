<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RequirementRawMaterial extends Model
{
    use HasFactory,Notifiable;
    protected $table = 'requirement_raw_materials';
    protected $fillable = [
        'menu_id',
        'raw_material_id',
        'qty'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }


}
