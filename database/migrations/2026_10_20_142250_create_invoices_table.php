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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('account_id')->constrained()->restrictOnDelete();
            $table->string('invoice_number', 40)->unique();
            $table->decimal('total', 20, 2);
            $table->char('currency', 3);
            $table->string('status', 32)->default('draft');
            $table->date('issued_on')->nullable();
            $table->date('due_on')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
