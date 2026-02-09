<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\ItemMaintenanceInfo;

class InventoryController extends Controller
{
    /**
     * Keep insert/update safe even if some columns don't exist
     */
    private function onlyExistingColumns(string $table, array $data): array
    {
        $filtered = [];
        foreach ($data as $col => $val) {
            if (Schema::hasColumn($table, $col)) {
                $filtered[$col] = $val;
            }
        }
        return $filtered;
    }

    public function index()
    {
        // dashboard.blade.php expects $items and uses ->itemID, ->itemName, ->category etc.
        $items = ItemMaintenanceInfo::orderByDesc('itemID')->paginate(10);

        return view('admin.ManageItemInformation.dashboard', compact('items'));
    }

    public function create()
    {
        return view('admin.ManageItemInformation.create');
    }

    public function store(Request $request)
    {
        // ✅ match your REAL table columns (item_maintenance_infos)
        $validated = $request->validate([
            'itemName'     => ['required', 'string', 'max:255'],
            'category'     => ['required', 'in:item,equipment'],
            'status'       => ['nullable', 'string', 'max:50'],
            'quantity'     => ['nullable', 'numeric'],
            'stockLevel'   => ['nullable', 'string', 'max:50'],
            'condition'    => ['nullable', 'string', 'max:50'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $table = (new ItemMaintenanceInfo)->getTable(); // should be item_maintenance_infos

        $data = [
            'itemName'     => $validated['itemName'],
            'category'     => $validated['category'],
            'status'       => $validated['status'] ?? 'available',
            'quantity'     => $validated['quantity'] ?? null,
            'stockLevel'   => $validated['stockLevel'] ?? null,
            'condition'    => $validated['condition'] ?? null,
            'description'  => $validated['description'] ?? null,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];

        $data = $this->onlyExistingColumns($table, $data);

        // Insert + get itemID
        $itemID = DB::table($table)->insertGetId($data);

        // Image upload -> item_images.imagePath (e.g. "items/xxx.jpg")
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $base = Str::slug($validated['itemName']);
            $ext  = $file->getClientOriginalExtension();
            $filename = $base . '-' . time() . '.' . $ext;

            $path = $file->storeAs('items', $filename, 'public'); // "items/filename.ext"

            DB::table('item_images')->updateOrInsert(
                ['itemID' => $itemID],
                ['imagePath' => $path, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return redirect()->route('admin.inventory.dashboard')
            ->with('success', 'Item created successfully.');
    }

    public function show($id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        $imageRow = DB::table('item_images')->where('itemID', $item->itemID)->first();
        $imageUrl = $imageRow ? asset('storage/' . $imageRow->imagePath) : null;

        return view('admin.ManageItemInformation.show', compact('item', 'imageUrl'));
    }

    public function edit($id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        $imageRow = DB::table('item_images')->where('itemID', $item->itemID)->first();
        $imageUrl = $imageRow ? asset('storage/' . $imageRow->imagePath) : null;

        return view('admin.ManageItemInformation.edit', compact('item', 'imageUrl'));
    }

    public function update(Request $request, $id)
    {
        $item  = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();
        $table = (new ItemMaintenanceInfo)->getTable();

        // ✅ match your REAL table columns
        $validated = $request->validate([
            'itemName'     => ['required', 'string', 'max:255'],
            'category'     => ['required', 'in:item,equipment'],
            'status'       => ['nullable', 'string', 'max:50'],
            'quantity'     => ['nullable', 'numeric'],
            'stockLevel'   => ['nullable', 'string', 'max:50'],
            'condition'    => ['nullable', 'string', 'max:50'],
            'description'  => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = [
            'itemName'     => $validated['itemName'],
            'category'     => $validated['category'],
            'status'       => $validated['status'] ?? $item->status,
            'quantity'     => $validated['quantity'] ?? $item->quantity,
            'stockLevel'   => $validated['stockLevel'] ?? $item->stockLevel,
            'condition'    => $validated['condition'] ?? $item->condition,
            'description'  => $validated['description'] ?? $item->description,
            'updated_at'   => now(),
        ];

        $data = $this->onlyExistingColumns($table, $data);

        DB::table($table)->where('itemID', $item->itemID)->update($data);

        // Optional replace image
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $base = Str::slug($validated['itemName']);
            $ext  = $file->getClientOriginalExtension();
            $filename = $base . '-' . time() . '.' . $ext;

            $path = $file->storeAs('items', $filename, 'public');

            DB::table('item_images')->updateOrInsert(
                ['itemID' => $item->itemID],
                ['imagePath' => $path, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return redirect()->route('admin.inventory.show', $item->itemID)
            ->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = ItemMaintenanceInfo::where('itemID', $id)->firstOrFail();

        DB::table('item_images')->where('itemID', $item->itemID)->delete();
        $item->delete();

        return redirect()->route('admin.inventory.dashboard')
            ->with('success', 'Item deleted successfully.');
    }
}

