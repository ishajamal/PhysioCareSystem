<?php

namespace App\Http\Controllers\admin\MonitorUsage;

use App\Http\Controllers\Controller;
use App\Models\usageRecord;
use App\Models\itemUsage;
use App\Models\itemMaintenanceInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class monitorUsageController extends Controller
{

   public function retrieveUsagerecord(Request $request)
{
    $perPage = (int) $request->get('perPage', 10);
    
    // 1. Calculate the most used item today (Keep your existing logic)
    $today = now()->startOfDay();
    $mostUsedToday = \App\Models\itemUsage::whereHas('usageRecord', function ($q) use ($today) {
            $q->whereDate('usageDate', $today);
        })
        ->with('itemMaintenanceInfo')
        ->select('itemID', DB::raw('SUM(quantityUsed) as total_qty'))
        ->groupBy('itemID')
        ->orderBy('total_qty', 'desc')
        ->first();

    // 2. Base query for the table using correct relationship names
    $query = itemUsage::with(['usageRecord.usedByUser', 'itemMaintenanceInfo'])
        ->join('usage_records', 'item_usages.usageID', '=', 'usage_records.usageID')
        ->select('item_usages.*');

    // 3. APPLY FILTERS (This was missing/commented out)
    
    // Filter by Staff Name
    if ($request->filled('userName')) {
        $query->whereHas('usageRecord.usedByUser', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->userName . '%');
        });
    }

    // Filter by Category
    if ($request->filled('itemCategory')) {
        $query->whereHas('itemMaintenanceInfo', function ($q) use ($request) {
            $q->where('category', $request->itemCategory);
        });
    }

    // Filter by Date Range
    if ($request->filled('dateStart')) {
        $query->whereDate('usage_records.usageDate', '>=', $request->dateStart);
    }
    if ($request->filled('dateEnd')) {
        $query->whereDate('usage_records.usageDate', '<=', $request->dateEnd);
    }

    // 4. Finalize and Paginate
    $itemUsages = $query->orderBy('usage_records.usageDate', 'desc')
        ->paginate($perPage)
        ->appends($request->query());

    return view('admin.MonitorUsage.monitorDashboard', compact('itemUsages', 'mostUsedToday'));
}
    /**
     * Retrieve all usage records for the dashboard
     * @return \Illuminate\View\View
     */
    // public function retrieveUsagerecord(Request $request)
    // {
    //     $perPage = (int) $request->get('perPage', 10);
    //     if (!in_array($perPage, [10, 25, 50, 100])) {
    //         $perPage = 10;
    //     }

    //     $itemUsages = itemUsage::with(['usageRecord.usedByUser', 'itemMaintenanceInfo'])
    //         ->join('usage_records', 'item_usages.usageID', '=', 'usage_records.usageID')
    //         ->orderBy('usage_records.usageDate', 'desc')
    //         ->select('item_usages.*')
    //         ->paginate($perPage)
    //         ->appends($request->query());

    //     return view('admin.MonitorUsage.monitorDashboard', compact('itemUsages'));
    // }

    /**
     * Handle filtered search based on user inputs
     * Supports filtering by: userName, itemCategory, dateStart, dateEnd
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    // public function displayfilteredsearh(Request $request)
    // {
    //     $validated = $request->validate([
    //         'userName' => 'nullable|string',
    //         'itemCategory' => 'nullable|string',
    //         'dateStart' => 'nullable|date',
    //         'dateEnd' => 'nullable|date',
    //         'perPage' => 'nullable|in:10,25,50,100'
    //     ]);

    //     $perPage = (int) $request->get('perPage', 10);
    //     if (!in_array($perPage, [10, 25, 50, 100])) {
    //         $perPage = 10;
    //     }

    //     $query = itemUsage::with(['usageRecord.usedByUser', 'itemMaintenanceInfo'])
    //         ->join('usage_records', 'item_usages.usageID', '=', 'usage_records.usageID');

    //     // Filter by user name if provided
    //     if (!empty($validated['userName'])) {
    //         $query->whereHas('usageRecord.usedByUser', function ($q) use ($validated) {
    //             $q->where('name', 'like', '%' . $validated['userName'] . '%');
    //         });
    //     }

    //     // Filter by item category if provided
    //     if (!empty($validated['itemCategory'])) {
    //         $query->whereHas('itemMaintenanceInfo', function ($q) use ($validated) {
    //             $q->where('category', $validated['itemCategory']);
    //         });
    //     }

    //     // Filter by date range if provided
    //     if (!empty($validated['dateStart'])) {
    //         $query->whereDate('usage_records.usageDate', '>=', $validated['dateStart']);
    //     }

    //     if (!empty($validated['dateEnd'])) {
    //         $query->whereDate('usage_records.usageDate', '<=', $validated['dateEnd']);
    //     }

    //     $itemUsages = $query->orderBy('usage_records.usageDate', 'desc')
    //         ->select('item_usages.*')
    //         ->paginate($perPage)
    //         ->appends($request->query());

    //     // If AJAX request, return JSON
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $itemUsages
    //         ]);
    //     }

    //     // Otherwise return view
    //     return view('admin.MonitorUsage.monitorDashboard', compact('itemUsages'));
    // }

    /**
     * Show details of a specific usage record
     * Redirects to monitorDetails page with full breakdown
     * @param int $usageID
     * @return \Illuminate\View\View
     */
    public function showusagedetails($usageID)
    {
        $usageRecord = usageRecord::with(['usedByUser', 'itemUsages.itemMaintenanceInfo'])
            ->findOrFail($usageID);

        // Get all item usages for this record
        $itemUsages = itemUsage::where('usageID', $usageID)
            ->with('itemMaintenanceInfo')
            ->get();

        return view('admin.MonitorUsage.monitorDetails', compact('usageRecord', 'itemUsages'));
    }

    /**
     * Refresh monitoring data - fetch latest data from database
     * Can be called via AJAX for live updates
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshMonitoringdata(Request $request)
    {
        $perPage = (int) $request->get('perPage', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        // Fetch latest item usages
        $itemUsages = itemUsage::with(['usageRecord.usedByUser', 'itemMaintenanceInfo'])
            ->join('usage_records', 'item_usages.usageID', '=', 'usage_records.usageID')
            ->orderBy('usage_records.usageDate', 'desc')
            ->select('item_usages.*')
            ->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $itemUsages,
                'message' => 'Data refreshed successfully'
            ]);
        }

        return redirect()->route('admin.usage.dashboard');
    }
}