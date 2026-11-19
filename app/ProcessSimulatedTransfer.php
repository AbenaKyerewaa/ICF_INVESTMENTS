<?php

namespace App;

use App\Models\Account;
use App\Models\Beneficiary;
use App\Models\Transfer;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;

class ProcessSimulatedTransfer
{
    /** @param array{account_id:int,beneficiary_id:int,amount:string,reference:?string,idempotency_key:string} $data */
    public function handle(User $user, array $data): Transfer
    {
        return DB::transaction(function () use ($user, $data): Transfer {
            $account = Account::query()
                ->whereBelongsTo($user)
                ->whereKey($data['account_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($account->status !== 'active') {
                throw new DomainException('Your sending account is not active.');
            }

            if (stripos($account->name, 'savings') !== false || $account->account_reference === 'ICF-SAVINGS-564') {
                throw new DomainException('Withdrawals and transfers are restricted on this Savings Account. Outgoing transfers can only be processed from your Checkings Account.');
            }
            $beneficiary = Beneficiary::query()->whereBelongsTo($user)->where('status', 'active')->whereKey($data['beneficiary_id'])->firstOrFail();
            $existing = Transfer::query()->where('sending_account_id', $account->id)->where('idempotency_key', $data['idempotency_key'])->first();
            if ($existing) {
                return $existing;
            }
            if (bccomp($account->balance, $data['amount'], 2) < 0) {
                throw new DomainException('Your account has insufficient available funds.');
            }

            // All outgoing transactions are declined with verification needed
            throw new DomainException('Transaction declined: Verification needed. Additional security clearance is required before this transaction can be processed. Please contact your private wealth manager.');
        });
    }
}
