<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('title', 100);
            $table->string('address', 150);
            $table->string('primary_number', 50);
            $table->string('secondary_number', 50)->nullable();
            $table->string('country', 50);
            $table->string('office_hours', 100);
            $table->string('email', 150)->nullable();
            $table->string('city', 50);
            $table->longText('map')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('offices');
    }
}
