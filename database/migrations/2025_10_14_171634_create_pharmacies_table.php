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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();

            //Basic Information
            $table->string('medicine_name');
            $table->string('generic_name');
            $table->enum('category', ['Antibiotic', 'Analgesics', 'Antidiabetics', 'Antihypertensives', 'Antihistamines', 'NSAIDs', 'Statins', 'Proton Pump Inhibitors', 'Other']);
            $table->enum('medicine_type', ['Over The Counter (OTC)', 'Controlled Substance']);
            $table->text('description')->nullable();
            // Radio Buttons
            $table->enum('medicine_form', ['Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream/Ointment', 'Drops', 'Other']);

            // Detailed Information
            $table->string('manufacturer');
            $table->string('supplier');
            $table->date('manufacturing_date');
            $table->date('expiry_date');
            $table->string('batch_number')->nullable();
            $table->string('dosage')->nullable();
            $table->string('side_effects')->nullable();
            $table->string('precautions_warnings')->nullable();

            //Inventory & Pricing
            $table->decimal('buying_price', 10, 2)->default(0.00);
            $table->decimal('selling_price', 10, 2)->default(0.00);
            $table->integer('quantity')->default(0);
            $table->integer('reorder_level')->default(10)->comment('Minimum stock before reorder alert');
            $table->decimal('tax_rate', 5, 2)->default(0.00)->comment('Tax rate percentage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
