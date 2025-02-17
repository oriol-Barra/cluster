<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producte extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom',
        'preu',
        'Quantitat',
        'tipus_impositiu',
        'foto_nom',
        'tipus',
    ];
    public function cerveses()
    {
        return $this->belongsToMany(Producte_elaborat::class, 'cervesa_producte')
                    ->withPivot('quantitat')
                    ->withTimestamps();
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
   
}
