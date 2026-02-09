<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ItemMaintenanceInfo;
use App\Models\MaintenanceRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $InProgressRequests = MaintenanceRequest::where('status', 'in progress')->count();
        $pendingRequests = MaintenanceRequest::where('status', 'pending')->count();
        $completedRequests = MaintenanceRequest::where('status', 'completed')->count();

        
        // Inventory
        $lowStockItems = ItemMaintenanceInfo::where('quantity', '<=', 5)->get();
        $lowStockCount = $lowStockItems->count();

        // Top Items (most used)
        $topItems = ItemMaintenanceInfo::withSum('itemUsages', 'quantityUsed')
            ->orderByDesc('item_usages_sum_quantityUsed')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'InProgressRequests', 
            'pendingRequests', 
            'completedRequests', 
            'lowStockItems', 
            'lowStockCount', 
            'topItems'
        ));
    }
}
