<?php

namespace App\Http\Controllers\therapist\RecordItemUsage;

use App\Http\Controllers\Controller;
use App\Models\itemMaintenanceInfo;
use App\Models\itemUsage;
use App\Models\usageRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsageController extends Controller
{
    protected function getTherapistId()
    {
        return Auth::id();
    }

    public function inventoryList()
    {
        $items = itemMaintenanceInfo::with('images')
                ->where('category','Item')
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

            // Note: Do NOT subtract stock yet, it will happen on submit
            // $item->quantity -= $request->quantity;
            // $item->save();

            DB::commit();

            return redirect()->route('therapist.usage.record')
                            ->with('success', 'Item added to cart successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to save usage record: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    // View cart
    public function viewCart()
    {
        $usageID = session('current_usage_id');
        $cartItems = collect(); // Empty collection by default

        // Only fetch if usageID exists AND actually exists in database
        if ($usageID && usageRecord::where('usageID', $usageID)->exists()) {
            $cartItems = itemUsage::with('itemMaintenanceInfo')
                        ->where('usageID', $usageID)
                        ->get();
        } else {
            // Clear bad session data
            session()->forget('current_usage_id');
        }

        // Get all available items for the "Add Item" modal dropdown
        $items = itemMaintenanceInfo::with('images')
                ->where('category', 'therapy supplies')
                ->where('status', 'available')
                ->get();
        
        return view('therapist.RecordItemUsage.UsageRecordCart', compact('cartItems', 'items'));
    }

   public function editCartItem($itemID)
{
    $usageID = session('current_usage_id');
    

    if (!$usageID) {
        return redirect()->route('therapist.usage.record')
                        ->withErrors(['error' => 'No active usage record!']);
    }

    $cartItem = itemUsage::with('itemMaintenanceInfo','usageRecord')
                ->where('usageID', $usageID)
                ->where('itemID', $itemID)
                ->firstOrFail();
    
    //dd($cartItem);
    return view('therapist.RecordItemUsage.EditUsageRecord', compact('cartItem'));
}

public function updateCartItem(Request $request, $itemID)
{
    $usageID = session('current_usage_id');

    if (!$usageID) {
        return redirect()->route('therapist.usage.record')
                        ->withErrors(['error' => 'No active usage record!']);
    }

    $request->validate([
        'quantityUsed' => 'required|integer|min:1',
    ]);

    $cartItem = itemUsage::where('usageID', $usageID)
                ->where('itemID', $itemID)
                ->firstOrFail();

    $cartItem->quantityUsed = $request->quantityUsed;
    $cartItem->save();

    return redirect()->route('therapist.usage.record')
                    ->with('success', 'Cart item updated successfully!');
}

// public function submitUsageRecord()
// {
//     $usageID = session('current_usage_id');

//     if (!$usageID) {
//         return redirect()->route('therapist.usage.record')
//                          ->withErrors(['error' => 'No active usage record to submit!']);
//     }

//     $cartItems = itemUsage::where('usageID', $usageID)->get();

//     DB::beginTransaction();
//     try {
//         foreach ($cartItems as $cart) {
//             $item = itemMaintenanceInfo::findOrFail($cart->itemID);

//             if ($item->quantity < $cart->quantityUsed) {
//                 throw new \Exception("Insufficient stock for item {$item->itemName}");
//             }

//             // Subtract stock
//             $item->quantity -= $cart->quantityUsed;
//             $item->save();
//         }

        

//         session()->forget('current_usage_id');

//         DB::commit();

//         return redirect()->route('therapist.usage.history')
//                          ->with('success', 'Usage record submitted successfully!');

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return back()->withErrors(['error' => 'Failed to submit usage record: ' . $e->getMessage()]);
//     }
// }
public function submitUsageRecord()
{
    $usageID = session('current_usage_id');

    if (!$usageID) {
        return redirect()->route('therapist.usage.record')
                         ->withErrors(['error' => 'No active usage record to submit!']);
    }

    $cartItems = itemUsage::where('usageID', $usageID)->get();

    DB::beginTransaction();
    try {
        foreach ($cartItems as $cart) {
            $item = itemMaintenanceInfo::findOrFail($cart->itemID);

            if ($item->quantity < $cart->quantityUsed) {
                throw new \Exception("Insufficient stock for item {$item->itemName}");
            }

            // Subtract stock
            $item->quantity -= $cart->quantityUsed;

            // Update status to "Unavailable" if quantity is 0
            if ($item->quantity <= 0) {
                $item->status = 'Unavailable';
                $item->quantity = 0; // ensure it doesn't go negative
            }

            $item->save();
        }

        session()->forget('current_usage_id');

        DB::commit();

        return redirect()->route('therapist.usage.history')
                         ->with('success', 'Usage record submitted successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Failed to submit usage record: ' . $e->getMessage()]);
    }
}


public function deleteCartItem($itemID)
{
    $usageID = session('current_usage_id');

    if (!$usageID) {
        return redirect()->route('therapist.usage.record')
                        ->withErrors(['error' => 'No active usage record!']);
    }

    $cartItem = itemUsage::where('usageID', $usageID)
                         ->where('itemID', $itemID)
                         ->first();

    if (!$cartItem) {
        return redirect()->route('therapist.usage.record')
                        ->withErrors(['error' => 'Item not found in cart!']);
    }

    try {
        $cartItem->delete();
        
        return redirect()->route('therapist.usage.record')
                        ->with('success', 'Item deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('therapist.usage.record')
                        ->withErrors(['error' => 'Failed to delete item.']);
    }
}
public function cancelUsage()
{
    $usageID = session('current_usage_id');

    if (!$usageID) {
        return redirect()->route('therapist.inventory.list')
                        ->withErrors(['error' => 'No active usage record']);
    }

    DB::beginTransaction();
    try {
        itemUsage::where('usageID', $usageID)->delete();
        usageRecord::where('usageID', $usageID)->delete();

        session()->forget('current_usage_id');

        DB::commit();

        return redirect()->route('therapist.inventory.list')
                        ->with('success', 'Usage record cancelled successfully!');

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->route('therapist.usage.record')
                        ->withErrors(['error' => 'Failed to cancel usage record']);
    }
}





}