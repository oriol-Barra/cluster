<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',

    ];
    //relació amb comanda(forma part de la comanda, order)
    public function order(){

        return $this->belongsTo(Order::class,'order_id');
    }
    //orderitem es la referència del producte dins de la comanda
    public function product(){

        return $this->belongsTo(ProducteElaborat::class);
    }
}
