<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_available_zone_id');
            $table->integer('destination_available_zone_id');
            $table->timestamp('inbound_date');
            $table->timestamp('outbound_date');
            $table->integer('max_group');
            $table->float('price_standar',12,2);
            $table->float('price_premier',12,2);
            $table->float('price_bussines',12,2);
            $table->enum('type_trip', ['direct', 'not_direct']);
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
        Schema::dropIfExists('available_trips');
    }
}
