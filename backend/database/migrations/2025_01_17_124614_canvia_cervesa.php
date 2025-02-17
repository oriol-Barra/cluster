<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CanviaCervesa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
            {           
                Schema::rename('cerveses', 'productes_elaborats');
                schema::rename('cervesa_producte','elaborats_producte');
            }
        

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::rename('producteselaborats', 'cerveses');
            schema::rename('elaborats_producte','cervesa_producte');

        }
    
}
