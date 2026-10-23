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
