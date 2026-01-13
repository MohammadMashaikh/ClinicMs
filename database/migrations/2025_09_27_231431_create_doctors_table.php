<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('primary_specialization_id');
            $table->unsignedBigInteger('secondary_specialization_id')->nullable();
            $table->string('license_number');
            $table->date('license_expiry_date');
            $table->text('qualifications');
            $table->integer('years_of_experience');
            

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('primary_specialization_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->foreign('secondary_specialization_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
