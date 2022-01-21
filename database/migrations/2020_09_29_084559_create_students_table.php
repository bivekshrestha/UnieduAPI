<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 150)->unique();
            $table->unsignedBigInteger('recruiter_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'paused'])->default('active');
            $table->enum('phase', [1, 2, 3, 4, 5])->default(1);
            $table->enum('lead_status', ['cold', 'warm', 'hot', 'pending'])->default('cold');
            $table->string('reference', 150)->nullable();;
            $table->timestamps();

            $table->foreign('recruiter_id')
                ->references('id')
                ->on('recruiters');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('lead_id')
                ->references('id')
                ->on('leads');

            $table->foreign('staff_id')
                ->references('id')
                ->on('staffs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
