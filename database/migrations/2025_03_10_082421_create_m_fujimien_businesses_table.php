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
        Schema::create('m_fujimien_businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_operator_code')->unique();
            $table->string('facility');
            $table->string('corporate');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('representative');
            $table->string('postal_code');
            $table->string('address');
            $table->text('special_notes')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_fujimien_businesses');
    }
};
