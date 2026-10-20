<?php

namespace App\Models;

use Database\Factories\LedgerEntryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['account_id', 'transfer_id', 'entry_reference', 'entry_type', 'amount', 'currency', 'status', 'description', 'occurred_at'])]
class LedgerEntry extends Model
{
    /** @use HasFactory<LedgerEntryFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'occurred_at' => 'datetime'];
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }
}
