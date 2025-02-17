<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProducteElaborat extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom',
        'preu',
        'Quantitat',
        'tipus_impositiu',
        'foto_nom',
        'recepta',
        'descripcio',
        'empresa_id',
        'tipus',
        'foto',
    ];
    protected $appends = ['preu_total'];

    public function productes()
    {
        return $this->belongsToMany(Producte::class, 'cervesa_producte')
                    ->withPivot('quantitat') // Incluye el atributo cantidad
                    ->withTimestamps();
    }
    public function getPreuTotalAttribute()
    {
        return $this->preu + ($this->preu * $this->tipus_impositiu);
    }

    //relacio amb el model orderItem(detall de la comanda)
    public function orderItems(){
        
        return $this->hasMany(OrderItem::class);
    }
}
