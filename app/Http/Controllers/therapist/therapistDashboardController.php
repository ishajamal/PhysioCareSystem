<?php
namespace App\Http\Controllers\therapist;

use App\Http\Controllers\Controller;
use App\Models\UsageRecord;
use App\Models\ItemMaintenance;
use App\Models\ItemUsage;

class therapistDashboardController extends Controller
{
    public function index()
    {
        // Totals
        $totalUsage = UsageRecord::count();
        $totalMaintenance = ItemMaintenance::count();

        /**
         * 🔥 Top Used Items (GLOBAL, Eloquent only)
         */
        $topUsedItems = ItemUsage::with('itemMaintenanceInfo')
            ->get()
            ->groupBy('itemID')
            ->map(function ($items) {
                return [
                    'itemName'   => optional($items->first()->itemMaintenanceInfo)->itemName ?? '-',
                    'total_used' => $items->sum('quantityUsed'),
                ];
            })
            ->sortByDesc('total_used')
            ->take(5)
            ->values();

        // Latest maintenance requests
        $latestMaintenanceRequests = ItemMaintenance::with('maintenanceRequest', 'itemInfo')
            ->latest()
            ->take(5)
            ->get();

        return view('therapist.dashboard', compact(
            'totalUsage',
            'totalMaintenance',
            'topUsedItems',
            'latestMaintenanceRequests'
        ));
    }
}
