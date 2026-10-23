<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $action = $request->query('action');
        $from = $request->query('from');
        $to = $request->query('to');
        $search = $request->query('search');

        $distinctActions = AuditLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $auditLogs = AuditLog::query()
            ->with('actor')
            ->when($action, fn ($query) => $query->where('action', $action))
            ->when($from, fn ($query) => $query->whereDate('occurred_at', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('occurred_at', '<=', $to))
            ->when($search, function ($query, $search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('action', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhereHas('actor', function ($actorQuery) use ($search): void {
                            $actorQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('occurred_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.audit-logs.index', compact('auditLogs', 'distinctActions', 'action', 'from', 'to', 'search'));
    }
}
