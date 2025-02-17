<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empreses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('CIFF'); // ciff de l'empresa
            $table->string('nom'); // nom de l'empresa
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Este es el campo que hace referencia al propietario
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
