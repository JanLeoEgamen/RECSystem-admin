<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberActivityLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MemberActivityLogController extends BaseController
{
    public function __construct()
    {
        // Only apply permission middleware to admin-specific methods
        $this->middleware('permission:view members')->only('adminIndex');
    }

    /**
     * For members to view their own logs
     */
    public function myLogs(Request $request)
    {
        $member = $request->user()->member;
        
        if (! $request->expectsJson()) {
            return view('member.activity-logs', [
                'member' => $member,
                'logTypes' => $this->getDistinctLogTypes($member),
                'logActions' => $this->getDistinctLogActions($member)
            ]);
        }

        // Updated query with eager loading
        $query = MemberActivityLog::with(['performer.roles']) // Load roles efficiently
            ->where('member_id', $member->id)
            ->latest();

        $logs = $this->applyFilters($query, $request)
            ->paginate($request->input('perPage', 20));

        return response()->json([
            'data' => $this->transformLogs($logs->items()),
            'current_page' => $logs->currentPage(),
            'last_page' => $logs->lastPage(),
            'total' => $logs->total(),
        ]);
    }

    /**
     * For admins to view any member's logs
     */
    public function adminIndex(Member $member, Request $request)
    {
        if (! $request->expectsJson()) {
            return view('admin.member-activity-logs', [
                'member' => $member,
                'logTypes' => $this->getDistinctLogTypes(),
                'logActions' => $this->getDistinctLogActions()
            ]);
        }

        $query = MemberActivityLog::with(['performer.roles']) // Load roles efficiently
            ->where('member_id', $member->id)
            ->latest();

        $logs = $this->applyFilters($query, $request)
            ->paginate($request->input('perPage', 20));

        return response()->json($this->createPaginationResponse($logs));
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('type')) {
            $query->where('type', $request->type);  
        }
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('details', 'like', '%'.$request->search.'%')
                  ->orWhere('type', 'like', '%'.$request->search.'%')
                  ->orWhere('action', 'like', '%'.$request->search.'%');
            });
        }

        return $query;
    }

    protected function transformLogs($logs)
    {
        return collect($logs)->map(function ($log) {
            return [
                'id' => $log->id,
                'type' => $this->formatType($log->type),
                'action' => $this->formatAction($log->action),
                'details' => $log->details,
                'meta' => $log->meta,
                'performed_by' => optional($log->performer->roles->first())->name ?? 'System',
                'created_at' => $log->created_at->format('d M, Y h:i A'),
                'created_at_raw' => $log->created_at->toDateTimeString(),
            ];
        });
    }

    protected function createPaginationResponse($paginator)
    {
        return [
            'data' => $this->transformLogs($paginator->items()),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
        ];
    }

    protected function formatType($type)
    {
        return ucfirst(str_replace(['_', '-'], ' ', $type));
    }

    protected function formatAction($action)
    {
        return ucfirst($action);
    }

    protected function getDistinctLogTypes(Member $member = null)
    {
        $query = MemberActivityLog::distinct('type')->orderBy('type');
        
        if ($member) {
            $query->where('member_id', $member->id);
        }

        return $query->pluck('type')
            ->mapWithKeys(fn ($type) => [$type => $this->formatType($type)]);
    }

    protected function getDistinctLogActions(Member $member = null)
    {
        $query = MemberActivityLog::distinct('action')->orderBy('action');
        
        if ($member) {
            $query->where('member_id', $member->id);
        }

        return $query->pluck('action')
            ->mapWithKeys(fn ($action) => [$action => $this->formatAction($action)]);
    }
}