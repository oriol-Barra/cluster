<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AfegeixDescripcio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empreses', function (Blueprint $table) {
            $table->text('descripcio')->nullable(); // Campo descripción, puede ser nulo    }
        });
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }
    public function down()
    {
        Schema::table('empreses', function (Blueprint $table) {
            $table->dropColumn(['descripcio']);
        });      
    }
}
