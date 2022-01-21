<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->unsignedSmallInteger('subject_id');
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->string('level', 50);
            $table->string('duration');
            $table->string('fee');
            $table->string('location');
            $table->string('url')->nullable();
            $table->text('details')->nullable();
            $table->text('requirements')->nullable();
            $table->timestamps();

            $table->foreign('institution_id')->on('institutions')->references('id')->onDelete('cascade');
            $table->foreign('subject_id')->on('subjects')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
