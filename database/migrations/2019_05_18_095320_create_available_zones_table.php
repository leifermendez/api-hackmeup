<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Usaremos codigo de paises ISO 3166-1 Alpha 2
        */
        Schema::create('available_zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 2);
            $table->string('time_zone', 40);
            $table->string('currency', 10);
            $table->string('contry_name', 50);
            $table->string('language', 2);
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
        Schema::dropIfExists('available_zones');
    }
}
