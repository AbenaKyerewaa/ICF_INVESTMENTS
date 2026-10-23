<?php

namespace Tests\Feature;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

/**
 * Phase 16 — Document Download Tests.
 *
 * Verifies that PDF statement and receipt routes enforce ownership,
 * validate date ranges and produce a downloadable response for the owner.
 */
class DocumentDownloadTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_owner_can_download_account_statement_as_pdf(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $customer->accounts()->firstOrFail();

        $response = $this->actingAs($customer)
            ->get(route('documents.statement', [
                'account' => $account,
                'from' => now()->subMonths(6)->toDateString(),
                'to' => now()->toDateString(),
            ]));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_statement_with_future_to_date_before_from_date_is_rejected(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $customer->accounts()->firstOrFail();

        // 'to' before 'from' should fail validation
        $this->actingAs($customer)
            ->get(route('documents.statement', [
                'account' => $account,
                'from' => now()->toDateString(),
                'to' => now()->subMonth()->toDateString(),
            ]))
            ->assertRedirect()
            ->assertInvalid(['to']);
    }

    public function test_guest_cannot_download_any_document(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();

        $account = $customer->accounts()->firstOrFail();

        $this->get(route('documents.statement', [
            'account' => $account,
            'from' => now()->subMonth()->toDateString(),
            'to' => now()->toDateString(),
        ]))->assertRedirect(route('login'));
    }

    public function test_owner_can_download_transfer_receipt_as_pdf(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();
        $account = $customer->accounts()->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        // Complete a transfer to generate a receipt
        $this->actingAs($customer)
            ->post(route('transfers.preview'), [
                'account_id' => $account->id,
                'beneficiary_id' => $beneficiary->id,
                'amount' => '75.00',
                'reference' => 'PDF receipt test',
            ])
            ->assertRedirect(route('transfers.review'));

        $this->actingAs($customer)
            ->post(route('transfers.confirm'))
            ->assertRedirect();

        $transfer = Transfer::query()
            ->where('sending_account_id', $account->id)
            ->latest()
            ->firstOrFail();

        $response = $this->actingAs($customer)
            ->get(route('documents.receipt', $transfer));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_attacker_cannot_download_another_users_receipt(): void
    {
        $this->seed();

        $customer = User::query()
            ->where('email', 'maya.bennett@icf-investment.demo')
            ->firstOrFail();
        $account = $customer->accounts()->firstOrFail();
        $beneficiary = $customer->beneficiaries()->firstOrFail();

        $transfer = Transfer::query()->create([
            'sending_account_id' => $account->id,
            'beneficiary_id' => $beneficiary->id,
            'reference' => 'TRF-ATK-PDF-01',
            'idempotency_key' => 'atk-pdf-idem-01',
            'amount' => '50.00',
            'currency' => 'USD',
            'status' => 'completed',
        ]);

        $attacker = User::factory()->create();

        $this->actingAs($attacker)
            ->get(route('documents.receipt', $transfer))
            ->assertNotFound();
    }
}
