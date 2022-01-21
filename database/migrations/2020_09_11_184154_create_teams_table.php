<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruiter_id');
            $table->string('name', 100);
            $table->string('description', 250)->nullable();
            $table->enum('type', ['handler', 'counsellor'])->default('counsellor');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('recruiter_id')
                ->references('id')
                ->on('recruiters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
