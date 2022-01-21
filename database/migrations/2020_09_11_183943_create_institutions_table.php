<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 150)->unique();
            $table->string('name', 200);
            $table->string('country', 100);
            $table->enum('route', ['pathway', 'direct', 'both'])->default('both');
            $table->string('email', 50)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('contact', 100)->nullable();
            $table->string('cities', 100)->nullable();
            $table->string('url', 100)->nullable();
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
        Schema::dropIfExists('institutions');
    }
}
