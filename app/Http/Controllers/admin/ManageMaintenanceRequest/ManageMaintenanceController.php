<?php

namespace App\Http\Controllers\admin\ManageMaintenanceRequest;

use App\Http\Controllers\Controller;
use App\Models\itemMaintenance;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class ManageMaintenanceController extends Controller
{
    public function index()
    {
        $requests = itemMaintenance::with(['maintenanceRequest.user', 'itemInfo'])->get();

        $unreadCount = MaintenanceRequest::where('isRead', false)->count();

        return view('admin.ManageMaintenanceRequest.ManageMaintenance', compact('requests', 'unreadCount'));
    }

    public function destroy($requestID)
    {
        $request = MaintenanceRequest::where('requestID', $requestID)->first();

        if ($request) {
            $request->delete();
            return redirect()->route('admin.maintenance.index')
                ->with('success', 'Maintenance record deleted successfully!');
        }

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

        return view('admin.ManageMaintenanceRequest.ViewMaintenance', compact('request'));
    }

    public function edit($id)
    {
        $request = MaintenanceRequest::with([
            'user',
            'images',
            'itemMaintenances.itemInfo'
        ])->where('requestID', $id)->firstOrFail();

        return view('admin.ManageMaintenanceRequest.EditMaintenanceRequest', compact('request'));
    }

    public function update(Request $httpRequest, $id)
    {
        $maintenanceReq = MaintenanceRequest::where('requestID', $id)->firstOrFail();
        
        $maintenanceReq->status = $httpRequest->input('status');
        $maintenanceReq->save();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Request updated successfully');
    }

    public function getNotificationCount()
    {
        $count = MaintenanceRequest::where('isRead', false)->count();
        return response()->json(['newCount' => $count]);
    }

    public function getNotifications()
    {
        $notifications = MaintenanceRequest::with(['user', 'itemMaintenances.itemInfo'])
            ->where('isRead', false)
            ->latest('dateSubmitted')
            ->take(5)
            ->get()
            ->map(function($req) {
                $itemName = 'Unknown Item';
                if ($req->itemMaintenances && $req->itemMaintenances->first() && $req->itemMaintenances->first()->itemInfo) {
                    $itemName = $req->itemMaintenances->first()->itemInfo->itemName;
                }

                return [
                    'id' => $req->requestID,
                    'submittedBy' => $req->user->name ?? 'Unknown User',
                    'itemName' => $itemName,
                    'date' => $req->dateSubmitted ? \Carbon\Carbon::parse($req->dateSubmitted)->diffForHumans() : 'Just now',
                ];
            });

        return response()->json($notifications);
    }

    public function markAsRead()
    {
        MaintenanceRequest::where('isRead', false)->update(['isRead' => true]);
        return response()->json(['status' => 'success']);
    }
}
