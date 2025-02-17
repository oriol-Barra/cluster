<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productes', function (Blueprint $table) {
            $table->id();
            $table->decimal('preu', 8, 2); // Preu
            $table->integer('Quantitat'); // Quantitat
            $table->decimal('tipus_impositiu', 5, 2); // Tipo impositivo (porcentaje)
            $table->string('nom',60);//nom del producte
            $table->json('recepta'); // Campo JSON para almacenar objetos
            $table->string("foto_nom",80);//foto del producte
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productes');
    }
}
