<?php

namespace App\Http\Controllers\therapist\SubmitMaintenanceRequest;

use App\Http\Controllers\Controller;
use App\Models\itemMaintenanceInfo;
use App\Models\itemMaintenance;
use App\Models\maintenanceRequest;
use App\Models\maintenanceRequestImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestController extends Controller
{
    /**
     * Support BOTH:
     * - old seed data: "equipment"
     * - newer detailed categories: "therapy equipment", "exercise equipment", "mobility aids"
     */
    private array $equipmentCategories = [
        'equipment',
        'therapy equipment',
        'exercise equipment',
        'mobility aids',
    ];

    // 1) Maintenance Request page (History list)
    public function index(Request $request)
    {
        $q = $request->query('q');

        $rows = maintenanceRequest::query()
            ->where('maintenance_requests.userID', Auth::id())
            ->leftJoin('item_maintenances', 'item_maintenances.requestID', '=', 'maintenance_requests.requestID')
            ->leftJoin('item_maintenance_infos', 'item_maintenance_infos.itemID', '=', 'item_maintenances.itemID')
            ->when($q, function ($query) use ($q) {
                $query->where('maintenance_requests.requestID', $q)
                    ->orWhere('maintenance_requests.status', 'like', "%{$q}%")
                    ->orWhere('item_maintenances.itemIssue', 'like', "%{$q}%")
                    ->orWhere('item_maintenance_infos.itemName', 'like', "%{$q}%");
            })
            ->select([
                'maintenance_requests.requestID',
                'maintenance_requests.dateSubmitted',
                'maintenance_requests.status',
                'maintenance_requests.isRead',
                'item_maintenances.itemIssue',
                'item_maintenances.itemID',
                'item_maintenance_infos.itemName as equipmentName',
            ])
            ->orderByDesc('maintenance_requests.dateSubmitted')
            ->paginate(10)
            ->withQueryString();

        return view('therapist.SubmitMaintenanceRequest.index', compact('rows', 'q'));
    }

    // 2) Add New Maintenance Request (Form)
    public function create(Request $request)
    {
        $items = itemMaintenanceInfo::query()
            ->whereIn('category', $this->equipmentCategories)
            ->orderBy('itemName', 'asc')
            ->get(['itemID', 'itemName', 'category']);

        $selectedItemID = $request->query('itemID');

        return view('therapist.SubmitMaintenanceRequest.create', compact('items', 'selectedItemID'));
    }

    // 3) Submit Maintenance Request (Store to DB)
    public function store(Request $request)
    {
        $request->validate([
            'itemID' => 'required|integer|exists:item_maintenance_infos,itemID',
            'itemIssue' => 'required|string|max:255',
            'detailsMaintenance' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Ensure selected item is EQUIPMENT category only
        $item = itemMaintenanceInfo::query()
            ->where('itemID', $request->itemID)
            ->whereIn('category', $this->equipmentCategories)
            ->firstOrFail();

        DB::beginTransaction();

        try {
            // (A) Create request header
            $mr = maintenanceRequest::create([
                'userID' => Auth::id(),
                'dateSubmitted' => now(),
                'status' => 'pending',
                'submittedBy' => Auth::id(),
                'isRead' => 0,
            ]);

            // (B) Create request details (includes itemID)
            itemMaintenance::create([
                'requestID' => $mr->requestID,
                'itemID' => $item->itemID,
                'itemIssue' => $request->itemIssue,
                'detailsMaintenance' => $request->detailsMaintenance,
            ]);

            // (C) Save evidence images (optional)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $filename = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('maintenance_images'), $filename);

                    maintenanceRequestImage::create([
                        'requestID' => $mr->requestID,
                        'imagePath' => 'maintenance_images/' . $filename,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('therapist.maintenance.index')
                ->with('success', 'Maintenance request submitted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to submit request: ' . $e->getMessage());
        }
    }

    // 4) View details of a request
    public function show($requestID)
    {
        $req = maintenanceRequest::query()
            ->where('requestID', $requestID)
            ->where('userID', Auth::id())
            ->firstOrFail();

        $details = itemMaintenance::query()
            ->where('requestID', $requestID)
            ->first();

        $images = maintenanceRequestImage::query()
            ->where('requestID', $requestID)
            ->get();

        // Optional: get equipment name for display
        $equipment = null;
        if ($details && isset($details->itemID)) {
            $equipment = itemMaintenanceInfo::query()->find($details->itemID);
        }

        return view('therapist.SubmitMaintenanceRequest.show', compact('req', 'details', 'images', 'equipment'));
    }
}
