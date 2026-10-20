<?php

namespace App\Models;

use Database\Factories\BeneficiaryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'display_name', 'account_identifier', 'institution_name', 'currency', 'status'])]
class Beneficiary extends Model
{
    /** @use HasFactory<BeneficiaryFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }
}
