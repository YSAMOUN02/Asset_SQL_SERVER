<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ChangeLog;
use App\Models\Limit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChangeLogController extends Controller
{
    public function ChangeLog(Request $request, $page = 1)
    {
        $viewpoint = Limit::first();
        $limit = $viewpoint->limit ?? 50;

        // Base query with eager load
        $query = ChangeLog::with('users');

        // 🔹 Optional filters
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('change_by')) {
            $query->where('change_by', $request->change_by);
        }

        // Get logs with pagination
        $changeLog = $query->latest('id')->paginate($limit, ['*'], 'page', $page);

        // Distinct values for filter dropdowns
        $change_by = ChangeLog::distinct()->pluck('change_by')->filter();
        $sections  = ChangeLog::distinct()->pluck('section')->filter();

        return view("backend.list-change-log", [
            'changeLog'    => $changeLog,                 // already has pagination info
            'change_by'    => $change_by,                 // for dropdown filter
            'sections'      => $sections,                   // for dropdown filter
            'total_page'   => $changeLog->lastPage(),     // total pages
            'total_record' => $changeLog->total(),        // total records
            'page'         => $changeLog->currentPage(),  // current page
            'limit'        => $limit,
            'filters'      => $request->only(['section', 'change_by']), // pass active filters
        ]);
    }

   public function searchChangeLog(Request $request)
{
    // Base query
    $query = ChangeLog::with('users');

    // 🔹 Optional filters
    if ($request->filled('record_id')) {
        $query->where('record_id', $request->record_id);
    }

    if ($request->filled('record_no')) {
        $query->where('record_no', 'like', '%' . $request->record_no . '%');
    }

    if ($request->filled('change')) {
        $query->where(function ($q) use ($request) {
            $q->where('new_values', 'like', '%' . $request->change . '%')
              ->orWhere('old_values', 'like', '%' . $request->change . '%');
        });
    }

    if ($request->filled('section')) {
        $query->where('section', $request->section);
    }

    if ($request->filled('change_by')) {
        $query->where('change_by', $request->change_by);
    }

    if ($request->filled('action')) {
        $query->where('action', $request->action);
    }

    // Date filters
    if ($request->filled('start_date') && !$request->filled('end_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if (!$request->filled('start_date') && $request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    // Paginate with default Laravel pagination (15 per page)
    $changeLog = $query->latest('id')->paginate();

    // Distinct values for dropdowns
    $change_by = ChangeLog::distinct()->pluck('change_by')->filter();
    $sections  = ChangeLog::distinct()->pluck('section')->filter();

    return view("backend.list-change-log", [
        'changeLog' => $changeLog,
        'change_by' => $change_by,
        'sections'  => $sections,
        'filters'   => $request->all(), // keep search inputs
    ]);
}

}
