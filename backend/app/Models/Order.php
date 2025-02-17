<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',

    ];
    //relació de comanda amb l'usuari
    
    public function user(){

        return $this->belongsTo(User::class);
    }
    
    //relació amb el detall de la comanda(OrderItem)
    public function items(){

        return $this->hasMany(OrderItem::class,'order_id');
    }
}
