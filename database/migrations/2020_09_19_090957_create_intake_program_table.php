<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntakeProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intake_program', function (Blueprint $table) {
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->on('programs')->references('id')->onDelete('cascade');

            $table->unsignedTinyInteger('intake_id');
            $table->foreign('intake_id')->on('intakes')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intake_program');
    }
}
