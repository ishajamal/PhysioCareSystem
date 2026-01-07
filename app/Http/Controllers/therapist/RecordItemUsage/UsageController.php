<?php

namespace App\Http\Controllers\therapist\RecordItemUsage;

use App\Http\Controllers\Controller;
use App\Models\itemMaintenanceInfo;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    public function inventoryList()
    {
        //get all items from database
        $items = itemMaintenanceInfo::where('category','therapy supplies')->get();

        return view('therapist.RecordItemUsage.InventoryList',compact('items'));
    }

    public function selectItem($itemID)
    {
        $item = itemMaintenanceInfo::where('itemID', $itemID)->firstOrFail();
        return view('therapist.RecordItemUsage.AddUsageRecord', compact('item'));
    }
    public function addUsageRecord($itemID)
    {
        // Find the item
        $item = itemMaintenanceInfo::where('itemID', $itemID)->firstOrFail();

        
        
        return view('therapist.RecordItemUsage.AddUsageRecord', compact('item'));
    }

    public function storeUsage(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:item_maintenance_infos,itemID',
            'quantity' => 'required|integer|min:1',
            'usage_date' => 'required|date',
            'therapist_name' => 'required|string',
            'patient_name' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        // Update item quantity
        $item = itemMaintenanceInfo::find($request->item_id);
        if ($item->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock!']);
        }
        
        // Deduct quantity
        $item->quantity -= $request->quantity;
        $item->save();
        
        // Save usage record (you need to create a usage_records table)
        // UsageRecord::create($validated);
        
        return redirect()->route('therapist.inventory.list')
                        ->with('success', 'Usage recorded successfully!');
    }
}
