<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProducteElaborat;
use App\Mail\ComandaMail; // Esta línea importa tu clase Mailable
use Illuminate\Support\Facades\Mail; // Esta línea es la que falta




class OrderController extends Controller
{
    //funció que genera una comanda:

        public function store(Request $request){
            //recuperació de l'usuario amb el token de sessió
            $user=$request->user();
            $carro = $request->input('carro'); // Suposem que el carro s'envia des del frontend

            if ($user) {
                    try{
                    //recollim el carro des del frontend i calculem el preu total
                    $totalAmount=collect($carro)->sum(function($item){
                        $product=ProducteElaborat::find($item['product_id']);
                        return $product->preu_total*$item['quantity'];
                    });
                    //generem la comanda
                    $order = Order::create([
                        'user_id' => $user->id,
                        'total_amount' => $totalAmount,
                        'status' => 'pending',
                    ]);
                    // Crear els ítems de la comanda
                    foreach ($carro as $item) {
                        $product = ProducteElaborat::find($item['product_id']);
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'price' => $product->preu_total,
                        ]);
                    }
                    //Mail::to('oriol.b.c@hotmail.com')->send(new ComandaMail($order)); // Reemplaza con el correo real del propietario


                    return response()->json(['message'=> 'comanda creada i correu enviat', 'order'=>$order],201);
                }catch(\Exception $e){
                    return response()->json(['message'=>'problema amb la comanda','error'=>$e->getMessage()],500);
                }

            } else {
                return response()->json(['message' => 'Usuari no autenticat.'], 401);
            }

        }
        public function borraComanda(){

        }
}
