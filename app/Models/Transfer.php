<?php

namespace App\Models;

use Database\Factories\TransferFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['sending_account_id', 'beneficiary_id', 'reference', 'idempotency_key', 'amount', 'currency', 'status', 'user_reference', 'failure_reason', 'completed_at', 'failed_at', 'metadata'])]
class Transfer extends Model
{
    /** @use HasFactory<TransferFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'completed_at' => 'datetime', 'failed_at' => 'datetime', 'metadata' => 'array'];
    }

    public function sendingAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'sending_account_id');
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function ledgerEntries(): HasMany
    {
        return $this->hasMany(LedgerEntry::class);
    }
}
