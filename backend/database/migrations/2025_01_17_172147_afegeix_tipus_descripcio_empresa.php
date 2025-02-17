<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AfegeixTipusDescripcioEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productes_elaborats', function (Blueprint $table) {
            $table->text('descripcio')->nullable(); // Campo descripción, puede ser nulo
            $table->string('tipus')->nullable();    // Campo tipo, puede ser nulo
            $table->foreignId('empresa_id')->constrained('empreses')->onDelete('cascade');
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productes_elaborats', function (Blueprint $table) {
            $table->dropColumn(['descripcio', 'tipus']);
        });    }
}
