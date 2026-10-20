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
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->restrictOnDelete();
            $table->foreignId('transfer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('entry_reference', 48)->unique();
            $table->string('entry_type', 16);
            $table->decimal('amount', 20, 2);
            $table->char('currency', 3);
            $table->string('status', 32)->default('completed');
            $table->string('description', 255);
            $table->timestamp('occurred_at');
            $table->timestamps();
            $table->index(['account_id', 'occurred_at']);
            $table->index(['transfer_id', 'entry_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};
