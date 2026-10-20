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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sending_account_id')->constrained('accounts')->restrictOnDelete();
            $table->foreignId('beneficiary_id')->constrained()->restrictOnDelete();
            $table->string('reference', 40)->unique();
            $table->string('idempotency_key', 80);
            $table->decimal('amount', 20, 2);
            $table->char('currency', 3);
            $table->string('status', 32)->default('pending');
            $table->string('user_reference', 140)->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->unique(['sending_account_id', 'idempotency_key']);
            $table->index(['sending_account_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
