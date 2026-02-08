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

        $item = $itemUsage->itemMaintenanceInfo;

        // Kira perbezaan
        $oldQuantity = $itemUsage->quantityUsed;
        $newQuantity = $request->quantity;
        $diff = $oldQuantity - $newQuantity; // positif = tambah balik stok

        $itemUsage->quantityUsed = $newQuantity;
        $itemUsage->save();

        // Update inventory
        $item->increment('quantity', $diff);

        // Update usage date
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

        $item = $itemUsage->itemMaintenanceInfo;

        // Tambah balik quantity ke inventory
        $item->increment('quantity', $itemUsage->quantityUsed);

        // Delete item usage
        $itemUsage->delete();

        return redirect()->route('therapist.view.history.details',[$usageID])
                        ->with('success', 'Item deleted successfully.');
    }


    protected function getTherapistId()
    {
        return Auth::id();
    }

    public function inventoryList($usageID)
    {
        $items = itemMaintenanceInfo::with('images')
                ->where('category','therapy supplies')
                ->where('status','available')
                ->get();

        return view('therapist.ManageUsageHistory.list-inventory', compact('items','usageID'));
    }

    public function selectItem($itemID)
    {
        $item = itemMaintenanceInfo::with('images')
                ->where('itemID', $itemID)
                ->firstOrFail();
        
        return view('therapist.ManageUsageHistory.AddNewRecord', compact('item'));
    }
    
    public function addNewRecord($usageID,$itemID)
    {
        $item = itemMaintenanceInfo::with('images')
                ->where('itemID', $itemID)
                ->firstOrFail();
        
        return view('therapist.ManageUsageHistory.AddNewRecord', compact('usageID','item'));
    }

    public function storeNewUsage(Request $request, $usageID)
    {
        $request->validate([
            'item_id'    => 'required|exists:item_maintenance_infos,itemID',
            'quantity'   => 'required|integer|min:1',
            'usage_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $usage = usageRecord::findOrFail($usageID);
            $item  = itemMaintenanceInfo::findOrFail($request->item_id);

            if ($item->quantity < $request->quantity) {
                return back()->withErrors(['quantity' => 'Not enough stock']);
            }

            $itemUsage = itemUsage::where('usageID', $usageID)
                ->where('itemID', $request->item_id)
                ->first();

            if ($itemUsage) {
                $itemUsage->quantityUsed += $request->quantity;
                $itemUsage->save();
            } else {
                itemUsage::create([
                    'usageID'      => $usageID,
                    'itemID'       => $request->item_id,
                    'quantityUsed' => $request->quantity,
                ]);
            }

            $item->decrement('quantity', $request->quantity);

            DB::commit();

            return redirect()
                ->route('therapist.view.history.details', $usageID)
                ->with('success', 'Item added successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id) {
       DB::beginTransaction();
        try {
            itemUsage::where('usageID', $id)->delete();
            usageRecord::where('usageID', $id)->delete();

            DB::commit();

            return redirect()->route('therapist.usage.history')
                            ->with('success', 'Usage record deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('therapist.usage.history')
                            ->withErrors(['error' => 'Failed to delete usage record']);
        }
    }


}
