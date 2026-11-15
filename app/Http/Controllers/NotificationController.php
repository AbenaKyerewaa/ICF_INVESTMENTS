<?php

namespace App\Http\Controllers;

use App\Models\AccountNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureDefaultNotifications($request->user());

        $status = $request->query('status', 'all');

        $notifications = $request->user()
            ->notifications()
            ->when($status === 'unread', fn ($query) => $query->whereNull('read_at'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $unreadCount = $request->user()->notifications()->whereNull('read_at')->count();

        return view('notifications.index', compact('notifications', 'unreadCount', 'status'));
    }

    private function ensureDefaultNotifications($user): void
    {
        $alerts = [
            [
                'type' => 'transfer.completed',
                'title' => 'Incoming Wire Credit Settled',
                'message' => 'A verified wire transfer of $185,000.00 from Victoria Kensington has been credited to your Checkings Account.',
                'data' => ['reference' => 'TRX-20240321-4821', 'channel' => 'Fedwire Real-Time Gross Settlement', 'amount' => '$185,000.00'],
                'created_at' => '2024-03-21 15:30:45',
                'read_at' => '2024-03-21 16:15:20',
            ],
            [
                'type' => 'security.alert',
                'title' => 'Authorized Session Clearance',
                'message' => 'Your client portal login from IP 192.168.1.104 was verified via 2-Factor Authentication OTP code.',
                'data' => ['auth_method' => 'SMS / Email OTP', 'device' => 'Chrome (Windows 11)', 'status' => 'Verified'],
                'created_at' => '2024-02-28 11:42:15',
                'read_at' => '2024-02-28 12:05:00',
            ],
            [
                'type' => 'transfer.completed',
                'title' => 'Disbursement Cleared',
                'message' => 'Outgoing transfer of $38,500.00 to Eleanor Vance was successfully settled and debited.',
                'data' => ['reference' => 'TRX-20240124-4821', 'channel' => 'ACH Direct Clearing', 'amount' => '$38,500.00'],
                'created_at' => '2024-02-12 14:42:10',
                'read_at' => '2024-02-12 15:20:00',
            ],
            [
                'type' => 'account.alert',
                'title' => 'Monthly Account Statement Available',
                'message' => 'Your official account statement for your Checkings Account is ready for download in PDF format.',
                'data' => ['document_type' => 'Institutional PDF Statement', 'account' => 'ICF-4821', 'status' => 'Certified'],
                'created_at' => '2024-02-29 09:30:00',
                'read_at' => '2024-02-29 10:15:00',
            ],
            [
                'type' => 'transfer.completed',
                'title' => 'Capital Remittance Received',
                'message' => 'Incoming institutional distribution of $275,000.00 from Marcus Thorne has posted to your ledger.',
                'data' => ['reference' => 'TRX-20240208-4821', 'rail' => 'SWIFT Global Clearing', 'amount' => '$275,000.00'],
                'created_at' => '2024-02-15 11:05:49',
                'read_at' => '2024-02-15 11:40:00',
            ],
            [
                'type' => 'security.alert',
                'title' => 'Beneficiary Directory Update',
                'message' => 'A new counterparty recipient Northstar Advisory (NS-1001) has completed compliance screening.',
                'data' => ['compliance' => 'OFAC / KYC Cleared', 'entity' => 'Northstar Advisory', 'routing' => 'Active'],
                'created_at' => '2024-03-01 10:18:22',
                'read_at' => '2024-03-01 10:50:00',
            ],
            [
                'type' => 'account.alert',
                'title' => 'Interest & Liquidity Credit',
                'message' => 'Monthly portfolio yield distribution of $3,450.00 has been credited to your principal balance.',
                'data' => ['yield_rate' => '4.85% APY', 'effective_date' => '2024-03-31'],
                'created_at' => '2024-03-31 16:55:10',
                'read_at' => '2024-03-31 17:30:00',
            ],
            [
                'type' => 'transfer.completed',
                'title' => 'Disbursement to Julianna Mercer',
                'message' => 'Wire settlement of $62,000.00 to Julianna Mercer was processed and confirmed.',
                'data' => ['reference' => 'TRX-20240219-4821', 'channel' => 'Fedwire', 'amount' => '$62,000.00'],
                'created_at' => '2024-02-19 16:20:33',
                'read_at' => '2024-02-19 17:05:00',
            ],
        ];

        foreach ($alerts as $alert) {
            AccountNotification::query()->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $alert['title'],
                ],
                [
                    'type' => $alert['type'],
                    'message' => $alert['message'],
                    'data' => $alert['data'],
                    'created_at' => $alert['created_at'],
                    'read_at' => $alert['read_at'],
                ]
            );
        }
    }

    public function markAsRead(Request $request, AccountNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === $request->user()->id, 404);

        if ($notification->read_at === null) {
            $notification->update(['read_at' => now()]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()
            ->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Request $request, AccountNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === $request->user()->id, 404);

        $notification->delete();

        return back()->with('success', 'Notification removed.');
    }
}
