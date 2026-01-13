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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->float('height');
            $table->float('weight');
            $table->text('allergies')->nullable();
            $table->text('current_medications')->nullable(); 
            $table->text('chronic_diseases')->nullable();
            $table->text('past_surgeries')->nullable();
            $table->text('previous_hospitalizations')->nullable();
            $table->json('family_medical_history')->nullable();
            $table->text('family_history_notes')->nullable();
            
            $table->string('insurance_provider');
            $table->string('policy_number');
            $table->string('policy_holder_name');
            $table->enum('relationship_to_patient', ['self', 'spouse', 'parent', 'child', 'other']);
            $table->string('insurance_phone_number');
            
            

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
