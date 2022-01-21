<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('first_name', 30);
            $table->string('middle_name', 20)->nullable();
            $table->string('last_name', 30);
            $table->enum('title', ['Mr', 'Ms', 'Mrs', 'Miss', 'Dr'])->nullable();
            $table->string('email', 191)->unique();

            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('country_of_birth', 50)->nullable();
            $table->string('nationality', 60)->nullable();

            $table->string('primary_address', 100)->nullable();
            $table->string('secondary_address', 100)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('postal_code', 25)->nullable();
            $table->string('primary_number', 50)->nullable();
            $table->string('secondary_number', 50)->nullable();

            $table->string('passport_number', 100)->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_issue_country', 50)->nullable();

            $table->boolean('has_english_qualification')->default(false);
            $table->string('english_qualification', 50)->nullable();
            $table->string('source_of_funding', 50)->nullable();

            $table->boolean('has_dual_citizenship')->default(false);
            $table->boolean('require_accommodation')->default(false);
            $table->boolean('require_pickup')->default(false);
            $table->boolean('require_insurance')->default(false);
            $table->boolean('has_medical_condition')->default(false);
            $table->longText('medical_condition')->nullable();
            $table->boolean('has_criminal_conviction')->default(false);
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
        Schema::dropIfExists('student_details');
    }
}
