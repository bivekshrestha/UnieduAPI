<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_region', function (Blueprint $table) {
            $table->unsignedMediumInteger('region_id');
            $table->foreign('region_id')->on('regions')->references('id')->onDelete('cascade');
            $table->unsignedMediumInteger('country_id');
            $table->foreign('country_id')->on('countries')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_region');
    }
}
