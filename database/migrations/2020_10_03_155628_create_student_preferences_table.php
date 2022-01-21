<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');

            $table->string('preferred_language', 50)->nullable();;
            $table->string('preferred_area_of_study', 50)->nullable();;
            $table->string('preferred_course_level', 50)->nullable();
            $table->string('preferred_area_course_comments', 200)->nullable();
            $table->string('preferred_career_path', 50)->nullable();
            $table->string('preferred_institutions', 50)->nullable();
            $table->string('preferred_intake', 50)->nullable();;
            $table->string('preferred_intake_comments', 200)->nullable();
            $table->string('preferred_year', 50)->nullable();;
            $table->string('preferred_destination1', 50)->nullable();;
            $table->string('preferred_destination2', 50)->nullable();
            $table->string('preferred_destination3', 50)->nullable();
            $table->string('preferred_destination_comments', 200)->nullable();

            $table->timestamps();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
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
        Schema::dropIfExists('student_preferences');
    }
}
