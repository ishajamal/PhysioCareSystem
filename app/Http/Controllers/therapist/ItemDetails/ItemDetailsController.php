<?php

namespace App\Http\Controllers\therapist\ItemDetails;

use App\Http\Controllers\Controller;
use App\Models\itemMaintenanceInfo;
use Illuminate\Http\Request;

class ItemDetailsController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $items = itemMaintenanceInfo::query()
            ->when($q, function ($query) use ($q) {
                $query->where('itemName', 'like', "%{$q}%")
                      ->orWhere('category', 'like', "%{$q}%")
                      ->orWhere('itemID', $q);
            })
            ->orderBy('itemID', 'asc')
            ->paginate(12)
            ->withQueryString();

        return view('therapist.ItemDetails.index', compact('items', 'q'));
    }

    public function show($itemID)
    {
        $item = itemMaintenanceInfo::with('images')->findOrFail($itemID);

        return view('therapist.ItemDetails.show', compact('item'));
    }
}
