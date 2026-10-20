<?php

namespace App;

use App\Models\Account;
use App\Models\AuditLog;
use App\Models\Beneficiary;
use App\Models\LedgerEntry;
use App\Models\Transfer;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcessSimulatedTransfer
{
    /** @param array{account_id:int,beneficiary_id:int,amount:string,reference:?string,idempotency_key:string} $data */
    public function handle(User $user, array $data): Transfer
    {
        return DB::transaction(function () use ($user, $data): Transfer {
            $account = Account::query()->whereBelongsTo($user)->whereKey($data['account_id'])->lockForUpdate()->firstOrFail();
            $beneficiary = Beneficiary::query()->whereBelongsTo($user)->where('status', 'active')->whereKey($data['beneficiary_id'])->firstOrFail();
            $existing = Transfer::query()->where('sending_account_id', $account->id)->where('idempotency_key', $data['idempotency_key'])->first();
            if ($existing) {
                return $existing;
            }
            if (bccomp($account->balance, $data['amount'], 2) < 0) {
                throw new DomainException('Your demo account has insufficient funds.');
            }
            $clearing = Account::query()->where('account_reference', 'ICF-DEMO-CLEARING')->lockForUpdate()->firstOrFail();
            $reference = 'TRF-'.Str::upper(Str::random(12));
            $transfer = Transfer::query()->create(['sending_account_id' => $account->id, 'beneficiary_id' => $beneficiary->id, 'reference' => $reference, 'idempotency_key' => $data['idempotency_key'], 'amount' => $data['amount'], 'currency' => $account->currency, 'status' => 'completed', 'user_reference' => $data['reference'], 'completed_at' => now(), 'metadata' => ['demo' => true]]);
            LedgerEntry::query()->create(['account_id' => $account->id, 'transfer_id' => $transfer->id, 'entry_reference' => "$reference-D", 'entry_type' => 'debit', 'amount' => $data['amount'], 'currency' => $account->currency, 'description' => 'DEMO/SIMULATED transfer to '.$beneficiary->display_name, 'occurred_at' => now()]);
            LedgerEntry::query()->create(['account_id' => $clearing->id, 'transfer_id' => $transfer->id, 'entry_reference' => "$reference-C", 'entry_type' => 'credit', 'amount' => $data['amount'], 'currency' => $account->currency, 'description' => 'DEMO/SIMULATED clearing entry', 'occurred_at' => now()]);
            $account->update(['balance' => bcsub($account->balance, $data['amount'], 2)]);
            $clearing->update(['balance' => bcadd($clearing->balance, $data['amount'], 2)]);
            AuditLog::query()->create(['actor_user_id' => $user->id, 'action' => 'transfer.completed', 'target_type' => 'transfer', 'target_id' => $transfer->id, 'metadata' => ['reference' => $reference, 'demo' => true], 'occurred_at' => now()]);

            return $transfer;
        });
    }
}
