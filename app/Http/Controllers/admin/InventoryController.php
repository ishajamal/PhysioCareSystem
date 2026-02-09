<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ItemMaintenanceInfo;

class InventoryController extends Controller
{
    // LIST
    public function index()
    {
        $items = ItemMaintenanceInfo::orderByDesc('itemID')->paginate(10);
        return view('admin.ManageItemInformation.dashboard', compact('items'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.ManageItemInformation.create');
    }

    // STORE
    public function store(Request $request)
    {
        // ✅ Conditional validation (no new attributes)
        $baseRules = [
            'itemName'     => ['required', 'string', 'max:255'],
            'category'     => ['required', 'in:item,equipment'],
            'status'       => ['nullable', 'string', 'max:50'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($request->category === 'item') {
            $extraRules = [
                'quantity'   => ['required', 'numeric'],
                'stockLevel' => ['required', 'string', 'max:50'],
                'condition'  => ['nullable', 'string', 'max:50'],
            ];
        } else {
            $extraRules = [
                'condition'  => ['required', 'string', 'max:50'],
                'quantity'   => ['nullable', 'numeric'],
                'stockLevel' => ['nullable', 'string', 'max:50'],
            ];
        }

        $validated = $request->validate($baseRules + $extraRules);

        // ✅ Clean irrelevant fields
        if ($validated['category'] === 'item') {
            $validated['condition'] = null;
        } else {
            $validated['quantity'] = null;
            $validated['stockLevel'] = null;
        }

        // ✅ Insert into item_maintenance_infos (ItemMaintenanceInfo model)
        $item = ItemMaintenanceInfo::create([
            'itemName'     => $validated['itemName'],
            'category'     => $validated['category'],
            'status'       => $validated['status'] ?? 'available',
            'quantity'     => $validated['quantity'] ?? null,
            'stockLevel'   => $validated['stockLevel'] ?? null,
            'condition'    => $validated['condition'] ?? null,
            'description'  => $validated['description'] ?? null,
        ]);

        // ✅ Image upload -> item_images table
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $base = Str::slug($validated['itemName']);
            $ext  = $file->getClientOriginalExtension();
            $filename = $base . '-' . time() . '.' . $ext;

            $path = $file->storeAs('items', $filename, 'public'); // items/xxx.jpg
           
            DB::table('item_images')->updateOrInsert(
                ['itemID' => $item->itemID],
                [
                    'imagePath'  => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->route('admin.inventory.dashboard')->with('success', 'Item created successfully.');
    }

    // SHOW
    public function show($id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        $imageRow = DB::table('item_images')->where('itemID', $item->itemID)->first();
        $imageUrl = $imageRow ? asset('storage/' . $imageRow->imagePath) : null;

        return view('admin.ManageItemInformation.show', compact('item', 'imageUrl'));
    }

    // EDIT FORM
    public function edit($id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        $imageRow = DB::table('item_images')->where('itemID', $item->itemID)->first();
        $imageUrl = $imageRow ? asset('storage/' . $imageRow->imagePath) : null;

        return view('admin.ManageItemInformation.edit', compact('item', 'imageUrl'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        $baseRules = [
            'itemName'     => ['required', 'string', 'max:255'],
            'category'     => ['required', 'in:item,equipment'],
            'status'       => ['nullable', 'string', 'max:50'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        if ($request->category === 'item') {
            $extraRules = [
                'quantity'   => ['required', 'numeric'],
                'stockLevel' => ['required', 'string', 'max:50'],
                'condition'  => ['nullable', 'string', 'max:50'],
            ];
        } else {
            $extraRules = [
                'condition'  => ['required', 'string', 'max:50'],
                'quantity'   => ['nullable', 'numeric'],
                'stockLevel' => ['nullable', 'string', 'max:50'],
            ];
        }

        $validated = $request->validate($baseRules + $extraRules);

        // clean irrelevant fields
        if ($validated['category'] === 'item') {
            $validated['condition'] = null;
        } else {
            $validated['quantity'] = null;
            $validated['stockLevel'] = null;
        }

        $item->update([
            'itemName'    => $validated['itemName'],
            'category'    => $validated['category'],
            'status'      => $validated['status'] ?? $item->status,
            'quantity'    => $validated['quantity'],
            'stockLevel'  => $validated['stockLevel'],
            'condition'   => $validated['condition'],
            'description' => $validated['description'] ?? null,
        ]);

        // replace image (optional)
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $base = Str::slug($validated['itemName']);
            $ext  = $file->getClientOriginalExtension();
            $filename = $base . '-' . time() . '.' . $ext;

            $path = $file->storeAs('items', $filename, 'public');

            DB::table('item_images')->updateOrInsert(
                ['itemID' => $item->itemID],
                [
                    'imagePath'  => $path,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        return redirect()->route('admin.inventory.show', $item->itemID)->with('success', 'Item updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        DB::table('item_images')->where('itemID', $item->itemID)->delete();
        $item->delete();

        return redirect()->route('admin.inventory.dashboard')->with('success', 'Item deleted successfully.');
    }
}
