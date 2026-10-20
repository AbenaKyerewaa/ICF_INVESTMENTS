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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('display_name');
            $table->string('account_identifier', 64);
            $table->string('institution_name')->nullable();
            $table->char('currency', 3);
            $table->string('status', 32)->default('active');
            $table->timestamps();
            $table->unique(['user_id', 'account_identifier']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
