<?php

namespace App\Http\Controllers\admin\MonitorUsage;

use App\Http\Controllers\Controller;
use App\Models\usageRecord;
use App\Models\itemUsage;
use App\Models\itemMaintenanceInfo;
use Illuminate\Http\Request;

class monitorUsageController extends Controller
{
    /**
     * Retrieve all usage records for the dashboard
     * @return \Illuminate\View\View
     */
    public function retrieveUsagerecord(Request $request)
    {
        $perPage = (int) $request->get('perPage', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $usageRecords = usageRecord::with(['usedByUser', 'itemUsages.itemMaintenanceInfo'])
            ->orderBy('usageDate', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.MonitorUsage.monitorDashboard', compact('usageRecords'));
    }

    /**
     * Handle filtered search based on user inputs
     * Supports filtering by: userName, itemCategory, dateStart, dateEnd
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function displayfilteredsearh(Request $request)
    {
        $validated = $request->validate([
            'userName' => 'nullable|string',
            'itemCategory' => 'nullable|string',
            'dateStart' => 'nullable|date',
            'dateEnd' => 'nullable|date',
            'perPage' => 'nullable|in:10,25,50,100'
        ]);

        $perPage = (int) $request->get('perPage', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = usageRecord::with(['usedByUser', 'itemUsages.itemMaintenanceInfo']);

        // Filter by user name if provided
        if (!empty($validated['userName'])) {
            $query->whereHas('usedByUser', function ($q) use ($validated) {
                $q->where('name', 'like', '%' . $validated['userName'] . '%');
            });
        }

        // Filter by item category if provided
        if (!empty($validated['itemCategory'])) {
            $query->whereHas('itemUsages.itemMaintenanceInfo', function ($q) use ($validated) {
                $q->where('category', $validated['itemCategory']);
            });
        }

        // Filter by date range if provided
        if (!empty($validated['dateStart'])) {
            $query->whereDate('usageDate', '>=', $validated['dateStart']);
        }

        if (!empty($validated['dateEnd'])) {
            $query->whereDate('usageDate', '<=', $validated['dateEnd']);
        }

        $usageRecords = $query->orderBy('usageDate', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $usageRecords
            ]);
        }

        // Otherwise return view
        return view('admin.MonitorUsage.monitorDashboard', compact('usageRecords'));
    }

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

        // Fetch latest usage records
        $usageRecords = usageRecord::with(['usedByUser', 'itemUsages.itemMaintenanceInfo'])
            ->orderBy('usageDate', 'desc')
            ->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $usageRecords,
                'message' => 'Data refreshed successfully'
            ]);
        }

        return redirect()->route('admin.usage.dashboard');
    }
}
