<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ManageItemInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index()
    {
        $items = ManageItemInformation::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ManageItemInformation.dashboard', compact('items'));
    }

    public function create()
    {
        return view('admin.ManageItemInformation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|max:100|unique:inventory_items,product_code',
            'product_name' => 'required|string|max:255',

            // ✅ category is now dropdown Item/Equipment
            'category' => 'required|in:Item,Equipment',

            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:200',
            'warranty_period' => 'nullable|string|max:100',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'status' => 'required|string|in:available,maintenance,in-use,out-of-stock',
            'location' => 'nullable|string|max:200',
            'notes' => 'nullable|string',

            // ✅ image upload
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['last_updated_by'] = auth()->user()->name;
        $validated['last_updated_date'] = now();

        // ✅ handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('inventory', 'public');
            $validated['image_path'] = $path;
        }

        try {
            $item = ManageItemInformation::create($validated);

            return redirect()->route('admin.inventory.show', $item->id)
                ->with('success', 'Item created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating item: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $item = ManageItemInformation::findOrFail($id);
        return view('admin.ManageItemInformation.show', compact('item'));
    }

    public function edit($id)
    {
        $item = ManageItemInformation::findOrFail($id);
        return view('admin.ManageItemInformation.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = ManageItemInformation::findOrFail($id);

        $validated = $request->validate([
            'product_code' => 'required|string|max:100',
            'product_name' => 'required|string|max:255',
            'category' => 'required|in:Item,Equipment',

            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:200',
            'warranty_period' => 'nullable|string|max:100',
            'last_maintenance_date' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'status' => 'required|string|in:available,maintenance,in-use,out-of-stock',
            'location' => 'nullable|string|max:200',
            'notes' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['last_updated_by'] = auth()->user()->name;
        $validated['last_updated_date'] = now();

        // ✅ handle new image (replace old)
        if ($request->hasFile('image')) {
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }

            $path = $request->file('image')->store('inventory', 'public');
            $validated['image_path'] = $path;
        }

        $item->update($validated);

        return redirect()->route('admin.inventory.show', $item->id)
            ->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $item = ManageItemInformation::findOrFail($id);

            // delete image too
            if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
                Storage::disk('public')->delete($item->image_path);
            }

            $itemName = $item->product_name;
            $item->delete();

            return redirect()->route('admin.inventory.dashboard')
                ->with('success', 'Item "' . $itemName . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventory.dashboard')
                ->with('error', 'Error deleting item: ' . $e->getMessage());
        }
    }
}
