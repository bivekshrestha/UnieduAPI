<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('price', 10);
            $table->string('commission_rate', 10);
            $table->string('application_limit', 10);
            $table->boolean('platform_access');
            $table->boolean('destination_countries');
            $table->boolean('student_portal');
            $table->boolean('institution_bonus');
            $table->string('operating_countries', 10);
            $table->string('transaction_fee', 5);
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
        Schema::dropIfExists('packages');
    }
}
