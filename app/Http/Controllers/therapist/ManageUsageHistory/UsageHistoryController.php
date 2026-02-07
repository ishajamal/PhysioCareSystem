<?php

namespace App\Http\Controllers\therapist\ManageUsageHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\itemMaintenanceInfo;
use App\Models\itemUsage;
use App\Models\usageRecord;
use Illuminate\Support\Facades\DB;

class UsageHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = usageRecord::with('itemUsages');

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('usageDate', $request->date);
        }

        $records = $query
            ->orderBy('usageDate', 'desc')
            ->get()
            ->map(function ($record) {
                return [
                    'usageID'     => $record->usageID,
                    'usageDate'   => $record->usageDate->format('Y-m-d'),
                    'totalItems'  => $record->itemUsages->sum('quantityUsed'),
                ];
            });

        return view('therapist.ManageUsageHistory.ListUsageHistory', compact('records'));
    }
    public function show($usageID)
    {
        $usage = UsageRecord::with([
            'usedByUser',
            'itemUsages.itemMaintenanceInfo'
        ])->findOrFail($usageID);

        $totalItems = $usage->itemUsages->sum('quantityUsed');

        return view('therapist.ManageUsageHistory.viewHistory', compact(
            'usage',
            'totalItems'
        ));
    }

    public function viewItemDetails($usageID, $itemID)
    {
        $itemUsage = ItemUsage::with([
            'usageRecord.usedByUser',
            'itemMaintenanceInfo.images'
        ])
        ->where('usageID', $usageID)
        ->where('itemID', $itemID)
        ->firstOrFail();

        return view('therapist.ManageUsageHistory.ViewDetailsHistory', compact('itemUsage'));
    }

    public function showUsageItemDetails($usage, $item)
    {
        $usage = itemUsage::with([
            'usedByUser',
            'itemUsages.itemMaintenanceInfo'
        ])->findOrFail($usage);

        $itemUsage = $usage->itemUsages
            ->where('itemID', $item)
            ->firstOrFail();

        return view(
            'therapist.ManageUsageHistory.ViewDetailsHistory',
            compact('usage', 'itemUsage')
        );
    }

    public function update(Request $request, $usageID, $itemID)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'usage_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $itemUsage = ItemUsage::where('usageID', $usageID)
                            ->where('itemID', $itemID)
                            ->firstOrFail();

        $itemUsage->quantityUsed = $request->quantity;
        $itemUsage->save();

        $usageRecord = $itemUsage->usageRecord;
        $usageRecord->usageDate = $request->usage_date;
        $usageRecord->save();

        return redirect()->route('therapist.view.history.item.details', [$usageID, $itemID])
                        ->with('success', 'Usage record updated successfully.');
    }
    public function edit($usageID, $itemID)
    {
        $itemUsage = ItemUsage::with([
            'usageRecord.usedByUser',
            'itemMaintenanceInfo.images'
        ])
        ->where('usageID', $usageID)
        ->where('itemID', $itemID)
        ->firstOrFail();

        return view('therapist.ManageUsageHistory.EditHistoryDetails', compact('itemUsage'));
    }
    public function destroy($usageID, $itemID)
    {
        $itemUsage = ItemUsage::where('usageID', $usageID)
                            ->where('itemID', $itemID)
                            ->firstOrFail();

        $itemUsage->delete();

        // Optionally, update the usageRecord total items or other logic here

        return redirect()->route('therapist.usage.history')
                        ->with('success', 'Item deleted successfully.');
    }

    protected function getTherapistId()
    {
        return Auth::id();
    }

    public function inventoryList()
    {
        $items = itemMaintenanceInfo::with('images')
                ->where('category','therapy supplies')
                ->where('status','available')
                ->get();

        return view('therapist.RecordItemUsage.InventoryList', compact('items'));
    }

    public function selectItem($itemID)
    {
        $item = itemMaintenanceInfo::with('images')
                ->where('itemID', $itemID)
                ->firstOrFail();
        
        return view('therapist.RecordItemUsage.AddUsageRecord', compact('item'));
    }
    
    public function addUsageRecord($itemID)
    {
        $item = itemMaintenanceInfo::with('images')
                ->where('itemID', $itemID)
                ->firstOrFail();
        
        return view('therapist.RecordItemUsage.AddUsageRecord', compact('item'));
    }

    public function storeUsage(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:item_maintenance_infos,itemID',
            'quantity' => 'required|integer|min:1',
            'usage_date' => 'required|date',
        ]);

        $item = itemMaintenanceInfo::findOrFail($request->item_id);

        DB::beginTransaction();
        try {
            $usageID = session('current_usage_id');

            // Create usage record if it doesn't exist
            if (!$usageID || !usageRecord::where('usageID', $usageID)->exists()) {
                $usageRecord = usageRecord::create([
                    'usedBy' => $this->getTherapistId(),
                    'usageDate' => $request->usage_date,
                ]);
                $usageID = $usageRecord->usageID;
                session(['current_usage_id' => $usageID]);
            }

            // Check if item already exists in the cart
            $existingCartItem = itemUsage::where('usageID', $usageID)
                                        ->where('itemID', $request->item_id)
                                        ->first();

            if ($existingCartItem) {
                // Increment quantityUsed instead of creating new row
                $existingCartItem->quantityUsed += $request->quantity;
                $existingCartItem->save();
            } else {
                // Create new cart item
                itemUsage::create([
                    'usageID' => $usageID,
                    'itemID' => $request->item_id,
                    'quantityUsed' => $request->quantity,
                ]);
            }

            $item->quantity -= $request->quantity;
            $item->save();

            DB::commit();

            return redirect()->route('therapist.usage.record')
                            ->with('success', 'Item added to cart successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to save usage record: ' . $e->getMessage()])
                        ->withInput();
        }
    }


}
