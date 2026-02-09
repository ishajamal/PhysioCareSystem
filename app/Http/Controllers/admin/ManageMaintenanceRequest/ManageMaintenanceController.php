<?php

namespace App\Http\Controllers\admin\ManageMaintenanceRequest;

use App\Http\Controllers\Controller;
use App\Models\itemMaintenance;
use App\Models\maintenanceRequest;
use Illuminate\Http\Request;

class ManageMaintenanceController extends Controller
{
    public function index()
    {
        $requests = itemMaintenance::with(['maintenanceRequest.user', 'itemInfo'])->get();

        $unreadCount = maintenanceRequest::where('isRead', false)->count();

        return view('admin.ManageMaintenanceRequest.ManageMaintenance', compact('requests', 'unreadCount'));
    }

    public function destroy($requestID)
    {
        // 1. Find the record
        $request = \App\Models\MaintenanceRequest::where('requestID', $requestID)->first();

        if ($request) {
            // 2. Delete the record
            $request->delete();

            // 3. ALWAYS redirect to the Index/List page.
            // This is safe for both the 'List View' and the 'Detail View'.
            return redirect()->route('admin.maintenance.index')
                            ->with('success', 'Maintenance record deleted successfully!');
        }

        // Handle case where record is already gone
        return redirect()->route('admin.maintenance.index')
                        ->with('error', 'Record not found.');
    }

    public function show($requestID)
    {
        $request = itemMaintenance::with([
            'maintenanceRequest.user',
            'maintenanceRequest.images',
            'itemInfo'
        ])->where('requestID', $requestID)->firstOrFail();


        $unreadCount = maintenanceRequest::where('isRead', false)->count();

        return view('admin.ManageMaintenanceRequest.ViewMaintenance', compact('request', 'unreadCount'));
    }

    // Fungsi tambahan untuk API (Notifikasi)
    public function getNotifications()
    {
        $notifications = maintenanceRequest::where('isRead', false)
            ->latest('dateSubmitted')
            ->take(5)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead()
    {
        maintenanceRequest::where('isRead', false)->update(['isRead' => true]);
        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::with([
        'user',                         
        'images',                       
        'itemMaintenances.itemInfo'     
    ])->where('requestID', $id)->firstOrFail();

    // // Debug: check the images
    // dd($request->images->map(fn($img) => $img->imagePath));
    return view('admin.ManageMaintenanceRequest.EditMaintenanceRequest', compact('request'));
    }
    // Handle the Save
    public function update(Request $httpRequest, $id)
    {
        // CORRECT: fetch the actual model using firstOrFail()
        $maintenanceReq = \App\Models\MaintenanceRequest::where('requestID', $id)->firstOrFail();

        // Now you can update properties because $maintenanceReq is a Model
        $maintenanceReq->status = $httpRequest->input('status');
        $maintenanceReq->save();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Request updated successfully');
    }
}
