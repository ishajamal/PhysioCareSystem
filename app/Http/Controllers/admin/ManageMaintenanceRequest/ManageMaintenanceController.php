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

        $currentStatus = strtolower(trim($maintenanceReq->status));
        $newStatus = strtolower(trim($httpRequest->input('status')));

        // 1. Define the Backend Workflow Rules (Ensures users can't bypass logic)
        $allowedTransitions = [
            'pending'   => ['pending', 'approved', 'completed', 'rejected', 'cancelled'],
            'approved'  => ['approved', 'completed', 'cancelled'],
            'completed' => ['completed'], // Locked
            'rejected'  => ['rejected'],  // Locked
            'cancelled' => ['cancelled'], // Locked
        ];

        // 2. Validate the state transition securely
        if ($currentStatus !== $newStatus) {
            if (!array_key_exists($currentStatus, $allowedTransitions)) {
                return back()->with('error', 'Unknown current status.');
            }
            if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
                return back()->with('error', "Invalid action. You cannot change a '{$currentStatus}' request to '{$newStatus}'.");
            }
        }

        // 3. If changing to completed, we MUST handle the file and remarks
        if ($newStatus === 'completed' && $currentStatus !== 'completed') {

            // Validate that they provided AT LEAST ONE form of proof securely
            // NOTE: Added 'nullable' so empty fields don't throw a string/file error!
            $httpRequest->validate([
                'proof_document' => 'required_without:proof_remarks|nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
                'proof_remarks'  => 'required_without:proof_document|nullable|string|max:1000',
            ], [
                'proof_document.required_without' => 'You must provide either an image/document or text remarks to complete this request.',
                'proof_remarks.required_without'  => 'You must provide either an image/document or text remarks to complete this request.',
            ]);

            // Save the File securely to the server
            if ($httpRequest->hasFile('proof_document')) {
                $file = $httpRequest->file('proof_document');
                $filename = time() . '_' . $file->hashName(); // Generates a safe, unique name

                // Stores in storage/app/public/maintenance_proofs
                $path = $file->storeAs('maintenance_proofs', $filename, 'public');
                $maintenanceReq->proof_document_path = $path;
            }

            // Save the Text Remarks
            if ($httpRequest->filled('proof_remarks')) {
                $maintenanceReq->proof_remarks = $httpRequest->input('proof_remarks');
            }
        }

        // 4. Save the final status
        $maintenanceReq->status = ucfirst($newStatus);
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
            ->map(function ($req) {
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
