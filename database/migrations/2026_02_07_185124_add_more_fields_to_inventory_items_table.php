<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('inventory_items', 'type')) {
                $table->string('type')->default('item')->after('category');
            }
            if (!Schema::hasColumn('inventory_items', 'description')) {
                $table->text('description')->nullable()->after('type');
            }
            if (!Schema::hasColumn('inventory_items', 'quantity')) {
                $table->integer('quantity')->default(1)->after('description');
            }
            if (!Schema::hasColumn('inventory_items', 'unit')) {
                $table->string('unit')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('inventory_items', 'brand')) {
                $table->string('brand')->nullable()->after('unit');
            }
            if (!Schema::hasColumn('inventory_items', 'model')) {
                $table->string('model')->nullable()->after('brand');
            }
            if (!Schema::hasColumn('inventory_items', 'serial_number')) {
                $table->string('serial_number')->nullable()->after('model');
            }
            if (!Schema::hasColumn('inventory_items', 'purchase_date')) {
                $table->date('purchase_date')->nullable()->after('serial_number');
            }
            if (!Schema::hasColumn('inventory_items', 'purchase_price')) {
                $table->decimal('purchase_price', 10, 2)->nullable()->after('purchase_date');
            }
            if (!Schema::hasColumn('inventory_items', 'supplier')) {
                $table->string('supplier')->nullable()->after('purchase_price');
            }
            if (!Schema::hasColumn('inventory_items', 'warranty_period')) {
                $table->string('warranty_period')->nullable()->after('supplier');
            }
            if (!Schema::hasColumn('inventory_items', 'last_maintenance_date')) {
                $table->date('last_maintenance_date')->nullable()->after('warranty_period');
            }
            if (!Schema::hasColumn('inventory_items', 'next_maintenance_date')) {
                $table->date('next_maintenance_date')->nullable()->after('last_maintenance_date');
            }
            if (!Schema::hasColumn('inventory_items', 'status')) {
                $table->string('status')->default('available')->after('next_maintenance_date');
            }
            if (!Schema::hasColumn('inventory_items', 'location')) {
                $table->string('location')->nullable()->after('status');
            }
            if (!Schema::hasColumn('inventory_items', 'notes')) {
                $table->text('notes')->nullable()->after('location');
            }
        });
    }

    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            // Remove columns if needed
            $columns = [
                'type', 'description', 'quantity', 'unit', 'brand', 'model',
                'serial_number', 'purchase_date', 'purchase_price', 'supplier',
                'warranty_period', 'last_maintenance_date', 'next_maintenance_date',
                'status', 'location', 'notes'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('inventory_items', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};